<?php

namespace App\Jobs;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessCarImagesJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, Dispatchable;

    protected Car $car;
    protected array $photoPaths;

    /**
     * عدد مرات إعادة المحاولة
     */
    public $tries = 3;

    /**
     * المهلة الزمنية للـ Job (بالثواني)
     */
    public $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(Car $car, array $photoPaths)
    {
        $this->car = $car;
        $this->photoPaths = $photoPaths;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('بدء معالجة صور السيارة', [
            'car_id' => $this->car->id,
            'photos_count' => count($this->photoPaths)
        ]);

        $manager = new ImageManager(new Driver());
        $optimizer = OptimizerChainFactory::create();

        $successCount = 0;
        $failedCount = 0;

        foreach ($this->photoPaths as $index => $path) {
            try {
                $this->processImage($path, $index, $manager, $optimizer);
                $successCount++;

            } catch (\Exception $e) {
                $failedCount++;
                Log::error('فشل معالجة الصورة', [
                    'car_id' => $this->car->id,
                    'path' => $path,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Log::info('انتهاء معالجة صور السيارة', [
            'car_id' => $this->car->id,
            'success' => $successCount,
            'failed' => $failedCount,
            'total' => count($this->photoPaths)
        ]);

        // إذا فشلت كل الصور، نرمي استثناء لإعادة المحاولة
        if ($successCount === 0 && count($this->photoPaths) > 0) {
            throw new \Exception('فشلت معالجة جميع الصور');
        }
    }

    /**
     * معالجة صورة واحدة
     */
    protected function processImage(string $path, int $index, ImageManager $manager, $optimizer): void
    {
        // التحقق من وجود الملف
        $fullPath = Storage::path($path);

        if (!file_exists($fullPath)) {
            throw new \Exception("الملف غير موجود: {$fullPath}");
        }

        Log::debug('معالجة الصورة', [
            'car_id' => $this->car->id,
            'index' => $index,
            'path' => $fullPath,
            'size' => filesize($fullPath)
        ]);

        // قراءة وتحويل الصورة
        $image = $manager->read($fullPath);
        $image->scaleDown(width: 1200, height: 1200);

        // تحويل إلى WebP بجودة 75%
        $webp = $image->toWebp(75);
        $filename = Str::uuid() . '.webp';

        // حفظ الصورة في Media Library
        $media = $this->car->addMediaFromString($webp->toString())
            ->usingFileName($filename)
            ->withCustomProperties([
                'original_path' => $path,
                'processed_at' => now()->toDateTimeString()
            ])
            ->toMediaCollection('cars');

        // تحسين الصورة (ضغط إضافي)
        $optimizer->optimize($media->getPath());

        // حذف الملف المؤقت
        Storage::delete($path);

        Log::debug('تمت معالجة الصورة بنجاح', [
            'car_id' => $this->car->id,
            'media_id' => $media->id,
            'filename' => $filename,
            'final_size' => filesize($media->getPath())
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('فشل Job معالجة الصور بشكل كامل', [
            'car_id' => $this->car->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);

        // يمكنك إرسال إشعار للمشرف هنا
        // Notification::send(admins, new JobFailedNotification($this->car, $exception));
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return [
            'process-images',
            'car:' . $this->car->id,
        ];
    }
}
