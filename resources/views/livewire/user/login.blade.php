<div wire:ignore.self class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">تسجيل الدخول</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- STEP 1 --}}
                @if ($step === 1)
                    <div>
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text"
                               wire:model.defer="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               placeholder="07xxxxxxxx">

                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <button wire:click="checkPhone"
                                class="btn btn-primary w-100 mt-3">
                            متابعة
                        </button>
                    </div>
                @endif

                {{-- STEP 2 --}}
                @if ($step === 2)
                    <div>
                        <label class="form-label">كلمة المرور</label>
                        <input type="password"
                               wire:model.defer="password"
                               class="form-control @error('password') is-invalid @enderror">

                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <button wire:click="login"
                                class="btn btn-success w-100 mt-3">
                            تسجيل الدخول
                        </button>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
