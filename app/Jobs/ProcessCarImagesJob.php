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
        $failedPaths = [];

        foreach ($this->photoPaths as $index => $path) {
            try {
                $this->processImage($path, $index, $manager, $optimizer);
                $successCount++;

            } catch (\Exception $e) {
                $failedCount++;
                $failedPaths[] = $path;

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

        // حفظ الفاشل في cache لإمكانية استرجاعها
        if ($failedCount > 0) {
            cache()->put('failed_images_car_' . $this->car->id, [
                'paths' => $failedPaths,
                'time' => now()
            ], now()->addHours(24));
        }

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
        // التحقق من وجود الملف في عدة مسارات محتملة
        $fullPath = $this->findImagePath($path);

        if (!$fullPath) {
            throw new \Exception("الملف غير موجود: {$path}");
        }

        Log::debug('معالجة الصورة', [
            'car_id' => $this->car->id,
            'index' => $index,
            'path' => $fullPath,
            'size' => filesize($fullPath)
        ]);

        // قراءة وتحويل الصورة
        $image = $manager->read($fullPath);

        // تغيير الحجم مع الحفاظ على النسبة
        $image->scaleDown(width: 1200, height: 1200);

        // إنشاء اسم فريد للصورة
        $filename = Str::uuid() . '.webp';

        // إنشاء مسار مؤقت للصورة المحولة
        $tempPath = storage_path('app/temp/' . $filename);

        // التأكد من وجود مجلد temp
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        // حفظ الصورة كـ WebP
        $image->toWebp(80)->save($tempPath);

        // تحسين الصورة (ضغط إضافي)
        $optimizer->optimize($tempPath);

        // إضافة الصورة إلى Media Library
        $media = $this->car->addMedia($tempPath)
            ->usingFileName($filename)
            ->withCustomProperties([
                'original_path' => $path,
                'processed_at' => now()->toDateTimeString(),
                'original_size' => file_exists($fullPath) ? filesize($fullPath) : 0,
                'final_size' => filesize($tempPath)
            ])
            ->toMediaCollection('cars');

        // حذف الملف المؤقت
        if (file_exists($tempPath)) {
            unlink($tempPath);
        }

        // حذف الملف الأصلي إذا كان في مسار مؤقت
        if (str_contains($fullPath, 'temp') || str_contains($fullPath, 'tmp')) {
            Storage::delete(str_replace(storage_path('app/'), '', $fullPath));
        }

        Log::debug('تمت معالجة الصورة بنجاح', [
            'car_id' => $this->car->id,
            'media_id' => $media->id,
            'filename' => $filename,
            'original_size' => $media->getCustomProperty('original_size'),
            'final_size' => $media->getCustomProperty('final_size'),
            'compression_ratio' => round((1 - $media->getCustomProperty('final_size') / $media->getCustomProperty('original_size')) * 100, 2) . '%'
        ]);
    }

    /**
     * البحث عن مسار الصورة في عدة أماكن
     */
    protected function findImagePath(string $path): ?string
    {
        // قائمة المسارات المحتملة
        $possiblePaths = [
            $path, // المسار الأصلي
            storage_path('app/' . $path),
            storage_path('app/public/' . $path),
            storage_path('app/temp/' . basename($path)),
            public_path('storage/' . $path),
            base_path($path)
        ];

        foreach ($possiblePaths as $possiblePath) {
            if (file_exists($possiblePath)) {
                return $possiblePath;
            }
        }

        return null;
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('فشل Job معالجة الصور بشكل كامل', [
            'car_id' => $this->car->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'attempt' => $this->attempts()
        ]);

        // حفظ الصور الفاشلة لمعالجتها لاحقاً
        cache()->put('failed_job_car_' . $this->car->id, [
            'car_id' => $this->car->id,
            'paths' => $this->photoPaths,
            'error' => $exception->getMessage(),
            'attempts' => $this->attempts(),
            'time' => now()
        ], now()->addDays(7));

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
