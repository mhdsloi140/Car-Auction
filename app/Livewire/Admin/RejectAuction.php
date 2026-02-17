<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Auction;

class RejectAuction extends Component
{
    public Auction $auction;

    public bool $showRejectConfirm = false;
    public bool $showEditPriceModal = false;

    public $price;

    protected $rules = [
        'price' => 'required|numeric|min:0'
    ];

    public function mount(Auction $auction)
    {
        $this->auction = $auction;
        $this->price   = $auction->price;
    }

    /* =========================
        الصلاحيات
    ==========================*/
    protected function authorizeAction()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'غير مصرح لك');
        }
    }

    /* =========================
        تعديل السعر
    ==========================*/
    public function openEditPrice()
    {
        $this->authorizeAction();
        $this->showEditPriceModal = true;
    }

    public function updatePrice()
    {
        $this->authorizeAction();
        $this->validate();

        $this->auction->update([
            'starting_price' => $this->price
        ]);

        $this->showEditPriceModal = false;

        session()->flash('success', 'تم تعديل السعر بنجاح');
    }

    /* =========================
        رفض المزاد
    ==========================*/
    public function confirmReject()
    {
        $this->authorizeAction();
        $this->showRejectConfirm = true;
    }

    public function reject()
    {
        $this->authorizeAction();

        $this->auction->update([
            'status' => 'rejected',
            'start_at' => now(),
            'end_at' => now()->addDay()
        ]);

        $this->showRejectConfirm = false;

        session()->flash('success', 'تم رفض المزاد بنجاح');
    }

    public function render()
    {
        return view('livewire.admin.reject-auction');
    }
}
