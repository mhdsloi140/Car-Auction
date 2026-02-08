<div>
    <div class="input-group mt-3">
        <input type="number" wire:model="amount" class="form-control">
        <button class="btn btn-success" wire:click="placeBid">
            زايد الآن
        </button>
    </div>

    @error('amount')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
