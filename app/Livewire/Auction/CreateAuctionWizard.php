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
                'photos' => 'required|array|min:1|max:8',
                'photos.*' => 'image|max:3072|mimes:jpg,jpeg,png,webp',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'report_pdf' => 'required|file|mimes:pdf,jpg,jpeg,png,webp|max:10240',
            ]);
        }
    }

    /**
     * الحصول على تسمية المواصفات
     */
    private function getSpecsLabel($specs)
    {
        return match ($specs) {
            'gcc' => 'خليجية',
            'non_gcc' => 'غير خليجية',
            'unknown' => 'غير معروف',
            default => $specs ?? 'غير محدد',
        };
    }

    /**
     * تنسيق رقم الهاتف العراقي
     */
    private function formatIraqiPhoneNumber($phone)
    {
        if (empty($phone)) {
            \Log::warning('formatIraqiPhoneNumber: رقم هاتف فارغ');
            return null;
        }

        // إزالة أي أحرف غير رقمية
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (empty($phone)) {
            return null;
        }

        // إزالة الصفر الأول إذا وجد
        $phone = ltrim($phone, '0');

        // إزالة 964 إذا كانت موجودة في البداية
        if (str_starts_with($phone, '964')) {
            $phone = substr($phone, 3);
        }

        // التأكد أن الرقم يبدأ بـ 7 (لأرقام الهواتف العراقية)
        if (!str_starts_with($phone, '7')) {
            return null;
        }

        // إضافة رمز العراق 964
        return '964' . $phone;
    }

    /**
     * إرسال إشعار للمشرفين
     */
    private function notifyAdmins($auction, UltraMsgService $ultra)
    {
        try {
            // جلب جميع المستخدمين الذين لديهم role admin
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

            // رابط المزاد
            $auctionUrl = route('auction.admin.show', $auction->id);

            // تنسيق الرسالة
            $message = " *مزاد جديد بانتظار الموافقة*\n\n";
            $message .= " *معلومات البائع:*\n";
            $message .= "الاسم: {$sellerName}\n";
            $message .= "رقم الجوال: {$sellerPhone}\n\n";
            $message .= " *للمراجعة:*\n";
            $message .= "اضغط على الرابط:\n{$auctionUrl}\n\n";
            // إرسال الرسالة لكل مشرف
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
            $reportPath = $this->report_pdf
                ? $this->report_pdf->storePublicly('cars_reports', 'public')
                : null;

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

            $photoPaths = [];
            foreach ($this->photos as $photo) {
                $photoPaths[] = $photo->store('tmp_photos');
            }

            $auction = $car->auction()->create([
                'seller_id' => auth()->id(),
                'status' => 'pending',
            ]);

            DB::commit();

            if (!empty($photoPaths)) {
                ProcessCarImagesJob::dispatch($car, $photoPaths);
            }

            // ✅ إرسال إشعار للمشرفين
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
