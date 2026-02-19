<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\DB;

class PlaceBid extends Component
{
    public Auction $auction;

    public $amount = null;
    public $selectedIncrement = null;
    public $increments = [50, 250, 1000, 50000,10000,25000];

    public $currentPrice;
    public $bidsCount = 0;
    public $latestBids = [];

    public $lastBidId = null;
    public $newBidAlert = null;

    public function mount(Auction $auction)
    {
        $this->auction = $auction;

        $lastBid = $auction->bids()->latest()->first();
        $this->currentPrice = $lastBid->amount ?? $auction->starting_price;
        $this->lastBidId = $lastBid->id ?? null;

        $this->bidsCount = $auction->bids()->count();
        $this->latestBids = $auction->bids()->latest()->take(10)->get();
    }

    public function setBidAmount($inc)
    {
        $this->selectedIncrement = $inc;
        $this->amount = $this->currentPrice + $inc;
    }

    public function placeBid()
    {
        $this->resetErrorBag();

        if (!auth()->check()) {
            $this->addError('amount', 'يجب تسجيل الدخول أولاً');
            return;
        }

        if (!$this->selectedIncrement) {
            $this->addError('amount', 'يرجى اختيار قيمة الزيادة أولاً');
            return;
        }

        try {
            DB::transaction(function () {
                // جلب المزاد مع قفل الصف لمنع أي تداخل
                $auction = Auction::lockForUpdate()->find($this->auction->id);

                if (!$auction) {
                    throw new \Exception('المزاد غير موجود');
                }

                if ($auction->status !== 'active') {
                    throw new \Exception('المزاد غير نشط');
                }

                // جلب آخر مزايدة مع قفل الصف أيضاً
                $lastBid = $auction->bids()->latest()->lockForUpdate()->first();
                $currentPrice = $lastBid->amount ?? $auction->starting_price;

                // التحقق من عدم وجود مزايدة جديدة منذ آخر تحديث للصفحة
                if ($lastBid && $lastBid->id != $this->lastBidId) {
                    throw new \Exception('تمت إضافة مزايدة جديدة، يرجى تحديث الصفحة والمحاولة مرة أخرى');
                }

                // منع المزايدة المتتالية من نفس المستخدم
                if ($lastBid && $lastBid->user_id == auth()->id()) {
                    throw new \Exception('لا يمكنك المزايدة مرتين متتاليتين');
                }

                // السعر الجديد
                $newAmount = $currentPrice + $this->selectedIncrement;

                // التحقق من أن السعر الجديد أكبر من السعر الحالي في المزاد
                if ($newAmount <= $auction->current_price) {
                    throw new \Exception('السعر المزايد به يجب أن يكون أكبر من السعر الحالي');
                }

                // إضافة المزايدة
                $bid = Bid::create([
                    'auction_id' => $auction->id,
                    'user_id' => auth()->id(),
                    'amount' => $newAmount,
                ]);

                if (!$bid) {
                    throw new \Exception('فشل في إضافة المزايدة');
                }

                // تحديث السعر الحالي في المزاد
                $auction->current_price = $newAmount;

                // تمديد الوقت في حال انتهت الفترة قريباً (أقل من 30 ثانية)
if ($auction->end_at && now()->greaterThan($auction->end_at->subMinutes(1))) {
    $auction->end_at = $auction->end_at->addMinutes(1);
}


                $auction->save();

                // تحديث البيانات في الواجهة مباشرة
                $this->currentPrice = $newAmount;
                $this->latestBids = $this->auction->bids()->latest()->take(10)->get();
                $this->bidsCount++;

                $this->lastBidId = $bid->id;
                $this->newBidAlert = [
                    'user_id' => $bid->user_id,
                    'amount' => $bid->amount,
                    'user_name' => auth()->user()->name,
                ];

                // إعادة تعيين الحقول
                $this->selectedIncrement = null;
                $this->amount = null;

                // إرسال حدث للمكونات الأخرى
                $this->dispatch('bid-placed', bidId: $bid->id);

            }, 5); // إعادة المحاولة 5 مرات في حالة deadlock

            session()->flash('success', 'تمت المزايدة بنجاح');

        } catch (\Illuminate\Database\QueryException $e) {
            // التعامل مع أخطاء قاعدة البيانات
            if ($e->errorInfo[1] == 1062) { // خطأ duplicate entry
                $this->addError('amount', 'حدث تضارب في المزايدة، يرجى المحاولة مرة أخرى');
            } else {
                $this->addError('amount', 'خطأ في قاعدة البيانات: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            $this->addError('amount', $e->getMessage());
        }
    }

    public function checkForNewBids()
    {
        try {
            // تحديث بيانات المزاد
            $this->auction->refresh();

            // جلب آخر مزايدة
            $latestBid = $this->auction->bids()->latest()->first();

            // التحقق من وجود مزايدة جديدة
            if ($latestBid && $latestBid->id != $this->lastBidId) {
                $this->lastBidId = $latestBid->id;

                // جلب معلومات المستخدم للمزايدة الجديدة
                $user = $latestBid->user;

                $this->newBidAlert = [
                    'user_id' => $latestBid->user_id,
                    'amount' => $latestBid->amount,
                    'user_name' => $user ? $user->name : 'مستخدم',
                ];

                $this->currentPrice = $latestBid->amount;
                $this->bidsCount = $this->auction->bids()->count();
                $this->latestBids = $this->auction->bids()->latest()->take(10)->get();

                // إعادة تعيين الزيادة المحددة إذا كانت أقل من السعر الجديد
                if ($this->selectedIncrement && ($this->currentPrice + $this->selectedIncrement) <= $this->currentPrice) {
                    $this->selectedIncrement = null;
                    $this->amount = null;
                }
            }

            // تحديث وقت الانتهاء في الواجهة
            if ($this->auction->end_at) {
                $this->dispatch('update-end-time',
                    endTime: $this->auction->end_at->setTimezone('UTC')->toIso8601String()
                );
            }

            // التحقق من حالة المزاد
            if ($this->auction->status !== 'active') {
                $this->dispatch('auction-ended');
            }

        } catch (\Exception $e) {
            // تسجيل الخطأ ولكن لا نوقفه للمستخدم
            logger()->error('Error in checkForNewBids: ' . $e->getMessage());
        }
    }

    public function getRemainingTimeProperty()
    {
        if (!$this->auction->end_at) {
            return null;
        }

        $now = now();
        $end = $this->auction->end_at;

        if ($now > $end) {
            return 'انتهى';
        }

        $diff = $now->diff($end);

        if ($diff->days > 0) {
            return $diff->days . ' يوم ' . $diff->h . ' ساعة';
        } elseif ($diff->h > 0) {
            return $diff->h . ' ساعة ' . $diff->i . ' دقيقة';
        } elseif ($diff->i > 0) {
            return $diff->i . ' دقيقة ' . $diff->s . ' ثانية';
        } else {
            return $diff->s . ' ثانية';
        }
    }

    public function render()
    {
        return view('livewire.user.place-bid', [
            'currentPrice' => $this->currentPrice,
            'latestBids' => $this->latestBids,
            'bidsCount' => $this->bidsCount,
            'remainingTime' => $this->remainingTime,
            'isActive' => $this->auction->status === 'active',
        ]);
    }
}
