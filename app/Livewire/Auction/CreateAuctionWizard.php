<?php

namespace App\Livewire\Auction;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Car;
use App\Models\Setting;
use App\Models\User;
use App\Services\UltraMsgService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class CreateAuctionWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;
    public bool $showModal = false;

    public ?int $brand_id = null;
    public ?int $model_id = null;
    public ?int $year = null;
    public string $city = '';
    public int $mileage = 0;
    public ?string $plate_number = null;
    public string $description = '';
    public ?string $specs = null;
    public array $photos = [];
    public $report_pdf = null;

    public $brands = [];
    public $models = [];
    public array $years = [];
    public string $modelSearch = '';

    protected $listeners = [
        'showCreateAuctionWizard' => 'openModal',
    ];

    public function mount()
    {
        $this->brands = Brand::orderBy('name')->get();
        $this->years = range(now()->year, 1980);
    }

    private function getFileSettings(): array
    {
        return [
            'max_images' => Setting::where('key', 'max_images')->value('value') ?? 8,
            'max_image_size' => Setting::where('key', 'max_image_size')->value('value') ?? 3,
            'allowed_extensions' => Setting::where('key', 'allowed_extensions')->value('value') ?? 'jpg,jpeg,png,webp',
        ];
    }

    public function updatedBrandId($value)
    {
        $this->model_id = null;
        $this->modelSearch = '';
        $this->models = CarModel::where('brand_id', $value)->orderBy('name')->get();
    }

    public function updatedModelSearch()
    {
        if (!$this->brand_id) {
            $this->models = [];
            return;
        }

        $this->models = CarModel::where('brand_id', $this->brand_id)
            ->where('name', 'like', "%{$this->modelSearch}%")
            ->orderBy('name')
            ->get();
    }

    public function openModal()
    {
        $this->resetExcept(['brands', 'years']);
        $this->step = 1;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset();
        $this->step = 1;
        $this->showModal = false;
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    protected function validateStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'brand_id' => 'required|exists:brands,id',
                'model_id' => 'required|exists:car_models,id',
                'year' => 'required|integer|between:1980,' . now()->year,
                'city' => 'required|string|max:255',
                'mileage' => 'required|integer|min:0',
                'description' => 'required|string|max:2000',
                'specs' => 'required|in:gcc,non_gcc,unknown',
            ]);
        }

        if ($this->step === 2) {
            $settings = $this->getFileSettings();
            $maxSizeKB = $settings['max_image_size'] * 1024;
            $extensions = collect(explode(',', $settings['allowed_extensions']))
                ->map(fn($ext) => trim($ext))
                ->implode(',');

            if (count($this->photos) > $settings['max_images']) {
                throw ValidationException::withMessages([
                    'photos' => "الحد الأقصى {$settings['max_images']} صورة"
                ]);
            }

            $this->validate([
                'photos' => "array|max:{$settings['max_images']}",
                'photos.*' => "image|max:$maxSizeKB|mimes:$extensions",
                'plate_number' => 'nullable|string|max:50',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'report_pdf' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            ]);
        }
    }

    public function save(UltraMsgService $ultra)
    {
        $this->validateStep();

        DB::beginTransaction();

        try {

            // رفع ملف التقرير
            $reportPath = $this->report_pdf
                ? $this->report_pdf->storePublicly('cars_reports', 'public')
                : null;

            // إنشاء السيارة
            $car = Car::create([
                'brand_id' => $this->brand_id,
                'model_id' => $this->model_id,
                'year' => $this->year,
                'city' => $this->city,
                'mileage' => $this->mileage,
                'plate_number' => $this->plate_number,
                'description' => $this->description,
                'specs' => $this->specs,
                'report_pdf' => $reportPath,
            ]);

            // معالجة الصور بأمان
            if (!empty($this->photos)) {

                $manager = new ImageManager(new Driver());
                $optimizer = OptimizerChainFactory::create();

            foreach ($this->photos as $photo) {

    // حجم الصورة الأصلية قبل المعالجة
    $originalSize = $photo->getSize();

    $image = $manager->read($photo->getRealPath());

    $image->scaleDown(width: 1200);

    $webp = $image->toWebp(75);

    $filename = Str::uuid() . '.webp';

    $media = $car->addMediaFromString($webp->toString())
        ->usingFileName($filename)
        ->toMediaCollection('cars');

    // ضغط إضافي
    $optimizer->optimize($media->getPath());

    // 🔥 هنا تضيف الفحص
    $compressedSize = filesize($media->getPath());

    logger()->info('Image Compression Check', [
        'original_kb'   => round($originalSize / 1024, 2),
        'compressed_kb' => round($compressedSize / 1024, 2),
        'ratio_%'       => round(
            100 - (($compressedSize / $originalSize) * 100),
            2
        ),
    ]);

    unset($image);
    unset($webp);
}

            }

            // إنشاء المزاد
            $auction = $car->auction()->create([
                'seller_id' => auth()->id(),
                'status' => 'pending',
            ]);

            DB::commit();

            // إشعار الأدمن
            $url = route('auction.show', $auction->id);

            $admins = User::role('admin')
                ->whereNotNull('phone')
                ->get();

            foreach ($admins as $admin) {
                $phone = preg_replace('/^0/', '', $admin->phone);
                $fullPhone = '+963' . $phone;

                $ultra->sendMessage(
                    $fullPhone,
                    "يوجد مزاد جديد بانتظار الموافقة.\nرابط المزاد:\n{$url}"
                );
            }

            session()->flash('success', 'تم إنشاء المزاد بنجاح');
            $this->closeModal();
            $this->dispatch('auctionCreated');

        } catch (\Throwable $e) {

            DB::rollBack();
            report($e);

            session()->flash('error', 'حدث خطأ أثناء إنشاء المزاد');
        }
    }

    public function render()
    {
        return view('livewire.auction.create-auction-wizard');
    }
}
