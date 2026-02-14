<div wire:ignore.self class="modal" id="loginModal">
    <div class="modal-content">

        <button class="modal-close" onclick="window.dispatchEvent(new Event('closeModal'))">×</button>

        <h3>مرحباً بك</h3>

        {{-- STEP 1: رقم الهاتف --}}
        @if ($step === 1)
            <p>أدخل رقم جوالك</p>
            <div class="phone-input-group">
                <span class="country-code">+966</span>
                <input type="text" wire:model.defer="phone" class="phone-input" placeholder="5xxxxxxxx" dir="ltr">
            </div>

            @error('phone')
                <div style="color:red;margin-top:5px">{{ $message }}</div>
            @enderror

            <button wire:click="checkPhone" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="checkPhone">متابعة</span>
                <span wire:loading wire:target="checkPhone"><i class="fas fa-spinner fa-spin"></i> جاري التحقق...</span>
            </button>
        @endif

        {{-- STEP 2: كلمة المرور --}}
        @if ($step === 2)
            <p>أدخل كلمة المرور</p>
            <input type="password" wire:model.defer="password" class="phone-input" style="margin-top:10px; border:1px solid #ccc; border-radius:8px; padding:12px;">

            @error('password')
                <div style="color:red;margin-top:5px">{{ $message }}</div>
            @enderror

            <button wire:click="login" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="login">تسجيل الدخول</span>
                <span wire:loading wire:target="login"><i class="fas fa-spinner fa-spin"></i> جاري الدخول...</span>
            </button>
        @endif

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openBtn = document.getElementById('openLoginBtn');
        if(openBtn){
            openBtn.addEventListener('click', function(){
                document.getElementById('loginModal').classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }

        window.addEventListener('closeModal', () => {
            document.getElementById('loginModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    });
</script>
