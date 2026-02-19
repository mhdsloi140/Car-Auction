<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Auction;

class RejectAuction extends Component
{
    public Auction $auction;
    public $message = '';

    public bool $showRejectConfirm = false;
    public bool $showEditPriceModal = false;

    public $starting_price;

    protected $rules = [
        'starting_price' => 'required|numeric'
    ];

    protected $messages = [
        'starting_price.required' => 'السعر الابتدائي مطلوب',
        'starting_price.numeric' => 'السعر يجب أن يكون رقماً',
        // 'starting_price.min' => 'السعر يجب أن يكون على الأقل 1000'
    ];

    public function mount(Auction $auction)
    {
        $this->auction = $auction;
        $this->starting_price = $auction->starting_price;
    }

    /* =========================
        صلاحيات الإدارة
    ==========================*/
    protected function authorizeAction()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'غير مصرح لك');
        }
    }

    /* =========================
        تعديل سعر المزاد
    ==========================*/
    public function openEditPrice()
    {
        $this->authorizeAction();
        $this->resetValidation();
        $this->showEditPriceModal = true;
    }

    public function updatePrice()
    {
        $this->authorizeAction();
        $this->validate();

        $this->auction->update([
            'starting_price' => $this->starting_price,
            'current_price' => $this->starting_price,
        ]);

        $this->showEditPriceModal = false;

 $this->message = 'تم تعديل سعر المزاد بنجاح';
    }

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
            'rejected_at' => now(),
        ]);

        $this->showRejectConfirm = false;

       $this->message = 'تم رفض المزاد بنجاح';
    }

    public function render()
    {
        return view('livewire.admin.reject-auction');
    }
}
