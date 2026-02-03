<?php

namespace App\Livewire\Auction;

use App\Models\Auction;
use App\Models\CarModel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class IndexAuction extends Component
{
    use WithPagination;

 
    public ?string $filterStatus = null;
    public ?string $filterCity = null;
    public ?int $filterBrand = null;
    public ?int $filterModel = null;
    public ?string $filterSpecs = null;

    public $models = [];

    protected $listeners = ['auctionCreated' => '$refresh'];


    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingFilterCity()   { $this->resetPage(); }
    public function updatingFilterBrand()
    {
        $this->resetPage();
        $this->filterModel = null;


        if ($this->filterBrand) {
            $this->models = CarModel::where('brand_id', $this->filterBrand)
                ->orderBy('name')
                ->get();
        } else {
            $this->models = [];
        }
    }
    public function updatingFilterModel()  { $this->resetPage(); }
    public function updatingFilterSpecs()  { $this->resetPage(); }

    public function render()
    {
        $query = Auction::with(['car.brand', 'car.model'])
            ->where('seller_id', Auth::id());

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterCity) {
            $query->whereHas('car', fn($q) => $q->where('city', $this->filterCity));
        }

        if ($this->filterBrand) {
            $query->whereHas('car', fn($q) => $q->where('brand_id', $this->filterBrand));
        }

        if ($this->filterModel) {
            $query->whereHas('car', fn($q) => $q->where('model_id', $this->filterModel));
        }

        if ($this->filterSpecs) {
            $query->whereHas('car', fn($q) => $q->where('specs', $this->filterSpecs));
        }

        $auctions = $query->latest()->paginate(8);

        return view('livewire.auction.index-auction', compact('auctions'));
    }
}
