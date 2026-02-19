<?php

namespace App\Livewire\Admin;

use App\Models\Auction;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class WinnerModal extends Component
{
    public $auction;
    public $show = false;

    protected $listeners = ['openWinnerModal' => 'open'];

    public function open($auctionId)
    {
        Log::info('Opening winner modal for auction: ' . $auctionId);

        $this->auction = Auction::with('winner')->find($auctionId);

        if (!$this->auction) {
            Log::error('Auction not found: ' . $auctionId);
            return;
        }

        if (!$this->auction->winner) {
            Log::error('Winner not found for auction: ' . $auctionId);
            return;
        }

        $this->show = true;
        $this->dispatch('modal-opened');

        Log::info('Modal opened successfully');
    }

    public function close()
    {
        Log::info('Closing modal');
        $this->show = false;
        $this->dispatch('modal-closed');
    }

    public function render()
    {
        return view('livewire.admin.winner-modal');
    }
}
