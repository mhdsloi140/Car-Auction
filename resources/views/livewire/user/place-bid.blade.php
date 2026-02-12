<div wire:poll.2s="checkForNewBids">
<div style="min-height: 90px;">
    @if($newBidAlert)
        <div class="alert alert-info">
            <strong>تمت إضافة مزايدة جديدة!</strong><br>
            رقم المزايد: {{ $newBidAlert['user_id'] }}<br>
            قيمة المزايدة: {{ number_format($newBidAlert['amount']) }} ريال
        </div>
    @endif
</div>


    <div class="input-group mt-3">
        <input type="number" wire:model="amount" class="form-control">
        <button class="btn btn-success" wire:click="placeBid">
            زايد الآن
        </button>
    </div>

    @error('amount')
    <div class="text-danger mt-1">
        {{ $message }}
    </div>
    @enderror
</div>
