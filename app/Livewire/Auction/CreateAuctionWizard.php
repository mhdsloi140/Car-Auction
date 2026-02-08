<?php

namespace App\Livewire\Auction;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Car;

class CreateAuctionWizard extends Component
{
    use WithFileUploads;

    public int $step = 1;
    public bool $showModal = false;

    // بيانات السيارة
    public ?int $brand_id = null;
    public ?int $model_id = null;
    public ?int $year = null;
    public string $city = '';
    public int $mileage = 0;
    public ?string $plate_number = null;
    public string $description = '';
    public ?string $specs = null;
    public array $photos = [];

    // أسعار المزاد
    public ?float $starting_price = null;
    public ?float $buy_now_price = null;

    // قوائم الاختيارات
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
            ->where('name', 'like', '%' . $this->modelSearch . '%')
            ->orderBy('name')->get();
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
        $messages = require resource_path('lang/custom_ar/validation.php');

        if ($this->step === 1) {
            $this->validate([
                'brand_id' => 'required|exists:brands,id',
                'model_id' => 'required|exists:car_models,id',
                'year' => 'required|integer|between:1980,' . now()->year,
                'city' => 'required|string|max:255',
                'mileage' => 'required|integer|min:0',
                'description' => 'required|string|max:2000',
                'specs' => 'required|in:gcc,non_gcc,unknown',
            ], $messages);
        }

        if ($this->step === 2) {
            $this->validate([
                'photos.*' => 'image|max:5120',
                'plate_number' => 'nullable|string|max:50',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'starting_price' => 'required|numeric|min:1',
                'buy_now_price' => 'nullable|numeric|gt:starting_price',
            ]);
        }
    }

    public function save()
    {
        $this->validateStep();

        DB::beginTransaction();

        try {
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

            // رفع كل الصور
            if ($this->photos && count($this->photos) > 0) {
                foreach ($this->photos as $photo) {
                    $car->addMedia($photo)
                        ->usingFileName($photo->getClientOriginalName())
                        ->toMediaCollection('cars');
                }
                $this->photos = [];
            }

            // إنشاء المزاد
            $car->auction()->create([
                'seller_id' => auth()->id(),
                'starting_price' => $this->starting_price,
                'buy_now_price' => $this->buy_now_price,
                'status' => 'pending',
            ]);

            DB::commit();

            session()->flash('success', 'تم إنشاء المزاد بنجاح');
            $this->closeModal();
            $this->dispatch('auctionCreated');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auction.create-auction-wizard');
    }
}
