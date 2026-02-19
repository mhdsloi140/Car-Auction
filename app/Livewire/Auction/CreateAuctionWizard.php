<?php

namespace App\Livewire\Auction;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Car;
use App\Services\UltraMsgService;
use App\Jobs\ProcessCarImagesJob;

class CreateAuctionWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;
    public bool $showModal = false;
    public bool $processing = false;

    public $brand_id = null;
    public $model_id = null;
    public $year = null;
    public $city = '';
    public $mileage = 0;
    public $plate_number = null;
    public $description = '';
    public $specs = null;

    public $photos = [];
    public $report_pdf = null;

    public $brands;
    public $models;
    public array $years = [];
    public $modelSearch = '';

    protected $listeners = [
        'showCreateAuctionWizard' => 'openModal',
    ];

    public function mount()
    {
        $this->brands = Brand::orderBy('name')->get();
        $this->models = collect();
        $this->years = range(now()->year, 1980);
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
            $this->models = collect();
            return;
        }

        $this->models = CarModel::where('brand_id', $this->brand_id)
            ->where('name', 'like', "%{$this->modelSearch}%")
            ->orderBy('name')
            ->get();
    }

    public function openModal()
    {
        $this->resetErrorBag();
        $this->step = 1;
        $this->showModal = true;
        $this->report_pdf = null;
        $this->photos = [];
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->step = 1;
        $this->resetErrorBag();
        $this->report_pdf = null;
        $this->photos = [];
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
            $this->validate([
                'photos' => 'array|max:8',
                'photos.*' => 'image|max:3072|mimes:jpg,jpeg,png,webp',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'report_pdf' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            ], [
                'report_pdf.required' => 'يرجى رفع ملف كشف السيارة',
                'report_pdf.mimes' => 'الملف يجب أن يكون pdf, jpg, jpeg, png, webp',
                'report_pdf.max' => 'حجم الملف لا يجب أن يتجاوز 10 ميجابايت',
            ]);
        }
    }

    
  public function save(UltraMsgService $ultra)
{
    if ($this->processing) return;
    $this->processing = true;

    $this->validateStep();

    DB::beginTransaction();

    try {
        // رفع ملف تقرير السيارة
        $reportPath = $this->report_pdf
            ? $this->report_pdf->storePublicly('cars_reports', 'public')
            : null;

        // إنشاء السيارة أولاً
        $car = Car::create([
            'brand_id'     => $this->brand_id,
            'model_id'     => $this->model_id,
            'year'         => $this->year,
            'city'         => $this->city,
            'mileage'      => $this->mileage,
            'plate_number' => $this->plate_number,
            'description'  => $this->description,
            'specs'        => $this->specs,
            'report_pdf'   => $reportPath,
        ]);

        // حفظ الصور مؤقتًا قبل إرسالها للـ Job
        $photoPaths = [];
        foreach ($this->photos as $photo) {
            $photoPaths[] = $photo->store('tmp_photos'); // storage/app/tmp_photos
        }

        // إنشاء المزاد المرتبط بالسيارة
        $auction = $car->auction()->create([
            'seller_id' => auth()->id(),
            'status'    => 'pending',
        ]);

        DB::commit();

        // إرسال الصور للمعالجة عبر queue
        if (!empty($photoPaths)) {
            \App\Jobs\ProcessCarImagesJob::dispatch($car, $photoPaths);
        }

        // إشعار المشرفين (اختياري)
        $this->notifyAdmins($auction, $ultra);

        // عرض رسالة نجاح وإغلاق الـ Modal
        session()->flash('success', 'تم إرسال السيارة للمراجعة بنجاح');
        $this->closeModal();
        $this->dispatch('auctionCreated');

    } catch (\Throwable $e) {
        DB::rollBack();
        report($e);
        session()->flash('error', 'حدث خطأ أثناء إنشاء المزاد: ' . $e->getMessage());
    } finally {
        $this->processing = false;
    }
}


    private function notifyAdmins($auction, $ultra)
    {
        // إضافة إشعارات المشرفين هنا إذا أردت (واتساب أو غيره)
    }

    public function render()
    {
        return view('livewire.auction.create-auction-wizard');
    }
}
