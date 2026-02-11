<?php

namespace App\Livewire\Admin;
use Livewire\Component;
use App\Models\Auction;

class RejectAuction extends Component
{
    public Auction $auction;
    public bool $showConfirm = false;

    public function mount(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function confirmReject()
    {
        $this->authorizeAction();
        $this->showConfirm = true;
    }

    public function reject()
    {
        $this->authorizeAction();

        $this->auction->update([
            'status' => 'rejected',
            'start_at' => now(),
            'end_at' => now()->addDay()
        ]);

        session()->flash('success', 'تم رفض المزاد بنجاح');

        return redirect()->route('auction.admin.show', $this->auction->id);
    }

    protected function authorizeAction()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'غير مصرح لك');
        }
    }

    public function render()
    {
        return view('livewire.admin.reject-auction');
    }
}
