<?php

namespace App\Livewire\User;

use App\Models\Auction;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class AuctionsList extends Component
{
    use WithPagination;

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
                ->when($this->selectedBrand, function ($q) {
                    $q->whereHas('car', function ($q) {
                        $q->where('brand_id', $this->selectedBrand);
                    });
                })
                ->latest()
                ->paginate(10),
        ]);
    }
}
