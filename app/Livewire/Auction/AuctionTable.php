<?php

namespace App\Livewire\Auction;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Auction;

class AuctionTable extends Component
{
    use WithPagination;

    public $statusFilter = null;

    protected $updatesQueryString = ['statusFilter']; 
    protected $listeners = ['showCreateCarWizard' => 'openForm'];

    public function openForm()
{
    $this->showForm = true;
}

public function closeForm()
{
    $this->reset();
    $this->step = 1;
    $this->showForm = false;
}


    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Auction::with('car', 'seller')->orderBy('created_at','desc');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $auctions = $query->paginate(5);

        return view('livewire.auction.auction-table', compact('auctions'));
    }
}
