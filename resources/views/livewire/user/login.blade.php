<div>

    <div wire:ignore.self class="modal" id="loginModal">
        <div class="modal-content">

            <button class="modal-close" onclick="window.dispatchEvent(new Event('closeModal'))">×</button>

            <h3>مرحباً بك</h3>

            {{-- STEP 1: إدخال رقم الجوال --}}
            @if ($step === 1)
            <p>أدخل رقم جوالك</p>

            <div class="phone-input-group">
                <span class="country-code">+964</span>
                <input type="text" wire:model="phone" class="phone-input" placeholder="7xxxxxxxx" dir="ltr">
            </div>

            @error('phone')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="checkPhone" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="checkPhone">متابعة</span>
                <span wire:loading wire:target="checkPhone"><i class="fas fa-spinner fa-spin"></i> جاري التحقق...</span>
            </button>

            <p class="register-link">
                ليس لديك حساب؟ <a href="#" wire:click.prevent="showRegisterForm">إنشاء حساب جديد</a>
            </p>
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
                <span class="country-code">+964</span>
                <input type="text" wire:model="reset_phone" class="phone-input" placeholder="7xxxxxxxx" dir="ltr">
            </div>

            @error('reset_phone')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="sendResetCode" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="sendResetCode">إرسال الكود</span>
                <span wire:loading wire:target="sendResetCode"><i class="fas fa-spinner fa-spin"></i> جاري الإرسال...</span>
            </button>
            @endif

            {{-- STEP 4: إدخال كود التحقق لاستعادة كلمة المرور --}}
            @if ($step === 4)
            <p>أدخل كود التحقق المرسل إلى جوالك</p>

            <input type="text" wire:model="reset_code" class="phone-input" placeholder="******" dir="ltr" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px; outline: none; transition: all 0.3s;" >

            @error('reset_code')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="verifyResetCode" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="verifyResetCode">تحقق</span>
                <span wire:loading wire:target="verifyResetCode"><i class="fas fa-spinner fa-spin"></i> جاري التحقق...</span>
            </button>
            @endif

            {{-- STEP 5: إدخال كلمة مرور جديدة --}}
            @if ($step === 5)
            <p>أدخل كلمة المرور الجديدة</p>

            <input type="password" wire:model="new_password" class="phone-input" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px; outline: none; transition: all 0.3s;">

            @error('new_password')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="saveNewPassword" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="saveNewPassword">حفظ كلمة المرور</span>
                <span wire:loading wire:target="saveNewPassword">
                    <i class="fas fa-spinner fa-spin"></i> جاري الحفظ...
                </span>
            </button>
            @endif

            {{-- STEP 6: نموذج إنشاء حساب جديد --}}
            @if ($step === 6)
            <p>إنشاء حساب جديد كبائع</p>

            <input type="text" wire:model="register_name" class="phone-input" placeholder="الاسم الكامل" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px; margin-bottom: 10px; width: 100%;">
            @error('register_name') <div class="error">{{ $message }}</div> @enderror

            <div class="phone-input-group" style="margin-bottom: 10px;">
                <span class="country-code">+964</span>
                <input type="text" wire:model="register_phone" class="phone-input" placeholder="7xxxxxxxx" dir="ltr">
            </div>
            @error('register_phone') <div class="error">{{ $message }}</div> @enderror

            <input type="password" wire:model="register_password" class="phone-input" placeholder="كلمة المرور" style="border: 1px solid #131111; border-radius: 8px; padding: 12px; margin-bottom: 10px; width: 100%;">
            @error('register_password') <div class="error">{{ $message }}</div> @enderror

            <input type="password" wire:model="register_password_confirmation" class="phone-input" placeholder="تأكيد كلمة المرور" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px; margin-bottom: 10px; width: 100%;">

            <button wire:click="sendRegisterCode" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="sendRegisterCode">متابعة</span>
                <span wire:loading wire:target="sendRegisterCode"><i class="fas fa-spinner fa-spin"></i> جاري التحقق...</span>
            </button>

            <p class="register-link" style="margin-top: 15px;">
                لديك حساب بالفعل؟ <a href="#" wire:click.prevent="backToLogin">تسجيل الدخول</a>
            </p>
            @endif

            {{-- STEP 7: إدخال كود التحقق للتسجيل --}}
            @if ($step === 7)
            <p>أدخل كود التحقق المرسل إلى جوالك</p>

            <input type="text" wire:model="register_code" class="phone-input" placeholder="******" dir="ltr" style="border: 1px solid #ddd; border-radius: 8px; padding: 12px; outline: none; transition: all 0.3s; margin-bottom: 10px;">

            @error('register_code')
            <div class="error">{{ $message }}</div>
            @enderror

            <button wire:click="verifyRegisterCode" wire:loading.attr="disabled" class="send-code-btn">
                <span wire:loading.remove wire:target="verifyRegisterCode">تفعيل الحساب</span>
                <span wire:loading wire:target="verifyRegisterCode"><i class="fas fa-spinner fa-spin"></i> جاري التفعيل...</span>
            </button>

            <p style="text-align: center; margin-top: 15px;">
                لم يصلك الكود؟ <a href="#" wire:click.prevent="resendRegisterCode">إعادة إرسال</a>
            </p>
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

            // استماع لأحداث الفلاش messages
            window.addEventListener('swal:modal', event => {
                Swal.fire({
                    title: event.detail.title,
                    text: event.detail.text,
                    icon: event.detail.icon,
                    confirmButtonText: 'حسناً'
                });
            });
        });
    </script>

    <style>
        .error {
            color: red;
            margin-top: 5px;
            margin-bottom: 10px;
            font-size: 14px;
            text-align: right;
        }

        .forgot-link, .register-link {
            margin-top: 15px;
            text-align: center;
        }

        .forgot-link a, .register-link a {
            color: #3498db;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .send-code-btn {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none !important;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .send-code-btn:hover:not(:disabled) {
            background: #2980b9;
        }

        .send-code-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .send-code-btn:focus {
            outline: none !important;
            box-shadow: none !important;
        }

        .phone-input-group {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .country-code {
            background: #f5f5f5;
            padding: 12px 15px;
            color: #333;
            font-weight: 500;
            border-left: 1px solid #ddd;
        }

        .phone-input {
            flex: 1;
            border: none !important;
            padding: 12px;
            font-size: 16px;
            outline: none;
        }

        .password-wrapper {
            position: relative;
            margin-bottom: 10px;
        }

        .password-field {
            width: 100%;
            border: 1px solid #ddd !important;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
        }

        .toggle-password {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }

        .toggle-password:hover {
            color: #333;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 400px;
            position: relative;
            direction: rtl;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            left: 10px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .modal-close:hover {
            color: #333;
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
