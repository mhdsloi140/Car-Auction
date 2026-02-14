<?php

namespace App\Livewire\User;

use App\Models\Auction;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class AuctionsList extends Component
{
    use WithPagination;
    public $price_min;
    public $price_max;
    public $year;
    public $specs;


    public function resetFilters()
    {
        $this->reset(['price_min', 'price_max', 'year', 'city']);
    }


    public $selectedBrand = null;

    protected $paginationTheme = 'bootstrap';

    public function selectBrand($brandId)
    {
        $this->selectedBrand = $brandId;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.user.auctions-list', [
            'brands' => Brand::all(),

            'auctions' => Auction::with(['car.brand'])
             ->where('status', 'active')
                ->when($this->selectedBrand, function ($q) {
                    $q->whereHas('car', fn($q) => $q->where('brand_id', $this->selectedBrand));
                })
                ->when($this->price_min, fn($q) => $q->where('starting_price', '>=', $this->price_min))
                ->when($this->price_max, fn($q) => $q->where('starting_price', '<=', $this->price_max))
                ->when($this->year, fn($q) => $q->whereHas('car', fn($q) => $q->where('year', $this->year)))
                ->when(
                    $this->specs,
                    fn($q) =>
                    $q->whereHas(
                        'car',
                        fn($q) =>
                        $q->where('specs', 'LIKE', "%{$this->specs}%")
                    )
                )

                ->latest()
                ->paginate(8),

        ]);
    }

}
