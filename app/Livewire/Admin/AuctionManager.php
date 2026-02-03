<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Auction;

class AuctionManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $statusFilter = '';

    
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }


    protected $listeners = ['refreshAuctions' => '$refresh'];

    public function mount()
    {

        // $this->dispatchBrowserEvent('startAutoRefresh');
    }

    public function render()
    {
        $auctions = Auction::with([
                'car.brand',
                'car.model',
                'seller'
            ])
            ->when($this->search, function ($query) {
                $query->whereHas('car', function ($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', '%' . $this->search . '%'))
                      ->orWhereHas('model', fn ($m) => $m->where('name', 'like', '%' . $this->search . '%'));
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.admin.auction-manager', [
            'auctions' => $auctions,
        ]);
    }
}
