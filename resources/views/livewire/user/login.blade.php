<div>

    <div wire:ignore.self class="modal" id="loginModal">
        <div class="modal-content">

            <button class="modal-close" onclick="window.dispatchEvent(new Event('closeModal'))">×</button>

            <h3>مرحباً بك</h3>

            {{-- STEP 1: إدخال رقم الجوال --}}
            @if ($step === 1)
            <p>أدخل رقم جوالك</p>

            <div class="phone-input-group">
                <span class="country-code">+966</span>
                <input type="text" wire:model="phone" class="phone-input" placeholder="5xxxxxxxx" dir="ltr">
            </div>

            @error('phone')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="checkPhone" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="checkPhone">متابعة</span>
                <span wire:loading wire:target="checkPhone"><i class="fas fa-spinner fa-spin"></i> جاري التحقق...</span>
            </button>
            @endif

            {{-- STEP 2: إدخال كلمة المرور --}}
            @if ($step === 2)
            <p>أدخل كلمة المرور</p>
            <div class="password-wrapper">
                <input type="password" wire:model="password" class="phone-input password-field" id="passwordInput">
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggleIcon"></i>
                </span>
            </div>

            @error('password')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="login" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="login">تسجيل الدخول</span>
                <span wire:loading wire:target="login"><i class="fas fa-spinner fa-spin"></i> جاري الدخول...</span>
            </button>

            <p class="forgot-link">
                <a href="#" wire:click.prevent="forgotPassword">هل نسيت كلمة المرور؟</a>
            </p>
            @endif

            {{-- STEP 3: إدخال رقم الجوال لاستعادة كلمة المرور --}}
            @if ($step === 3)
            <p>أدخل رقم جوالك لاستعادة كلمة المرور</p>

            <div class="phone-input-group">
                <span class="country-code">+966</span>
                <input type="text" wire:model="reset_phone" class="phone-input" placeholder="5xxxxxxxx" dir="ltr">
            </div>

            @error('reset_phone')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="sendResetCode" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="sendResetCode">إرسال الكود</span>
                <span wire:loading wire:target="sendResetCode"><i class="fas fa-spinner fa-spin"></i> جاري
                    الإرسال...</span>
            </button>
            @endif

            {{-- STEP 4: إدخال كود التحقق --}}
            @if ($step === 4)
            <p>أدخل كود التحقق المرسل إلى جوالك</p>

            <input type="text" wire:model="reset_code" class="phone-input" placeholder="******" dir="ltr">

            @error('reset_code')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="verifyResetCode" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="verifyResetCode">تحقق</span>
                <span wire:loading wire:target="verifyResetCode"><i class="fas fa-spinner fa-spin"></i> جاري
                    التحقق...</span>
            </button>
            @endif

            {{-- STEP 5: إدخال كلمة مرور جديدة --}}
            @if ($step === 5)
            <p>أدخل كلمة المرور الجديدة</p>

            <input type="password" wire:model="new_password" class="phone-input">

            @error('new_password')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="saveNewPassword" wire:loading.attr="disabled" class="send-code-btn"
                style="border: none; outline: none; box-shadow: none;">
                <span wire:loading.remove wire:target="saveNewPassword">حفظ كلمة المرور</span>
                <span wire:loading wire:target="saveNewPassword">
                    <i class="fas fa-spinner fa-spin" style="margin-left: 5px;"></i>
                    جاري الحفظ...
                </span>
            </button>
            @endif

        </div>
    </div>

    {{-- Script التحكم في فتح وإغلاق المودال --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const openBtn = document.getElementById('openLoginBtn');

            if (openBtn) {
                openBtn.addEventListener('click', function () {
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

    <style>
        /* نفس التنسيقات الموجودة عندك */
        .error {
            color: red;
            margin-top: 5px;
            font-size: 14px;
        }

        .forgot-link {
            margin-top: 15px;
            text-align: center;
        }

        .forgot-link a {
            color: #3498db;
            text-decoration: none;
        }

        .send-code-btn,
        .send-code-btn:focus,
        .send-code-btn:active,
        .send-code-btn:hover {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }
        .send-code-btn:focus {
    outline: none !important;
    box-shadow: none !important;
}
    </style>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('toggleIcon');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</div>
