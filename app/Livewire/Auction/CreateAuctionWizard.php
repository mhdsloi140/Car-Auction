<?php

namespace App\Livewire\Auction;

use App\Models\User;
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
    public $report_images = []; // مصفوفة الصور

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
        $this->models = CarModel::where('brand_id', $value)
            ->orderBy('name')
            ->get();
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
        $this->report_images = [];
        $this->photos = [];
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->step = 1;
        $this->resetErrorBag();
        $this->report_images = [];
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

    /**
     * دالة حذف صورة من مصفوفة report_images
     */
    public function removeImage($index)
    {
        if (isset($this->report_images[$index])) {
            // حذف الصورة من المصفوفة
            unset($this->report_images[$index]);
            // إعادة ترتيب المصفوفة
            $this->report_images = array_values($this->report_images);

            // رسالة اختيارية
            // session()->flash('success', 'تم حذف الصورة بنجاح');
        }
    }

    /**
     * دالة حذف صورة من مصفوفة photos (إذا احتجتها)
     */
    public function removePhoto($index)
    {
        if (isset($this->photos[$index])) {
            unset($this->photos[$index]);
            $this->photos = array_values($this->photos);
        }
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
                'photos' => 'required|array|min:1|max:8',
                'photos.*' => 'image|max:3072|mimes:jpg,jpeg,png,webp',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'report_images' => 'required|array|min:1|max:5',
                'report_images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'report_images.required' => 'الرجاء رفع صورة واحدة على الأقل',
                'report_images.min' => 'الرجاء رفع صورة واحدة على الأقل',
                'report_images.max' => 'يمكنك رفع 5 صور كحد أقصى',
                'report_images.*.image' => 'الملف يجب أن يكون صورة',
                'report_images.*.mimes' => 'الصورة يجب أن تكون من نوع: jpg, jpeg, png, webp',
                'report_images.*.max' => 'حجم الصورة لا يجب أن يتجاوز 2 ميجابايت',
            ]);
        }
    }

    private function getSpecsLabel($specs)
    {
        return match ($specs) {
            'gcc' => 'خليجية',
            'non_gcc' => 'غير خليجية',
            'unknown' => 'غير معروف',
            default => $specs ?? 'غير محدد',
        };
    }

    private function formatIraqiPhoneNumber($phone)
    {
        if (empty($phone)) {
            \Log::warning('formatIraqiPhoneNumber: رقم هاتف فارغ');
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (empty($phone)) {
            return null;
        }

        $phone = ltrim($phone, '0');

        if (str_starts_with($phone, '964')) {
            $phone = substr($phone, 3);
        }

        if (!str_starts_with($phone, '7')) {
            return null;
        }

        return '964' . $phone;
    }

    private function notifyAdmins($auction, UltraMsgService $ultra)
    {
        try {
            $admins = User::role('admin')
                ->whereNotNull('phone')
                ->get();

            if ($admins->isEmpty()) {
                \Log::warning('لا يوجد مشرفين بأرقام هواتف');
                return;
            }

            $car = $auction->car;
            $sellerName = auth()->user()->name;
            $sellerPhone = auth()->user()->phone;
            $auctionUrl = route('auction.admin.show', $auction->id);

            $message = " *مزاد جديد بانتظار الموافقة*\n\n";
            $message .= " *معلومات البائع:*\n";
            $message .= "الاسم: {$sellerName}\n";
            $message .= "رقم الجوال: {$sellerPhone}\n\n";
            $message .= " *للمراجعة:*\n";
            $message .= "اضغط على الرابط:\n{$auctionUrl}\n\n";

            foreach ($admins as $admin) {
                try {
                    $formattedPhone = $this->formatIraqiPhoneNumber($admin->phone);

                    if (!$formattedPhone) {
                        continue;
                    }

                    $result = $ultra->sendMessage($formattedPhone, $message);

                    if ($result) {
                        \Log::info('تم إرسال إشعار للمشرف', [
                            'admin_id' => $admin->id,
                            'admin_name' => $admin->name,
                            'auction_id' => $auction->id
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error('خطأ في إرسال إشعار للمشرف', [
                        'admin_id' => $admin->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

        } catch (\Exception $e) {
            \Log::error('خطأ في notifyAdmins: ' . $e->getMessage());
        }
    }

    public function save(UltraMsgService $ultra)
    {
        if ($this->processing)
            return;

        $this->processing = true;
        $this->validateStep();

        DB::beginTransaction();

        try {
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
            ]);

            // حفظ صور التقرير (report_images) باستخدام Spatie MediaLibrary
            if (!empty($this->report_images)) {
                foreach ($this->report_images as $image) {
                    $car->addMedia($image)
                        ->toMediaCollection('car_reports'); // collection خاصة بتقارير السيارة
                }
            }

            // حفظ مسارات الصور المؤقتة للـ Job
            $photoPaths = [];
            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $photoPaths[] = $photo->store('tmp_photos', 'public');
                }
            }

            $auction = $car->auction()->create([
                'seller_id' => auth()->id(),
                'status' => 'pending',
            ]);

            DB::commit();

            // معالجة الصور في الخلفية
            if (!empty($photoPaths)) {
                ProcessCarImagesJob::dispatch($car, $photoPaths);
            }

            // إرسال إشعار للمشرفين
            $this->notifyAdmins($auction, $ultra);

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

    public function render()
    {
        return view('livewire.auction.create-auction-wizard');
    }
}
