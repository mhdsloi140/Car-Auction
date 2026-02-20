<div>
    <div wire:ignore.self class="modal" id="loginModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-content">
            <button class="modal-close" id="closeModalBtn" aria-label="إغلاق" onclick="window.dispatchEvent(new Event('closeModal'))">&times;</button>
            <div class="modal-icon">
                <i class="fas fa-car"></i>
            </div>

            {{-- STEP 1: إدخال رقم الجوال --}}
            @if ($step === 1)
            <h3 id="modalTitle">تسجيل الدخول إلى سيّر</h3>
            <p>أدخل رقم هاتفك</p>

            <form wire:submit.prevent="checkPhone">
                <div class="phone-field">
                    <label for="phone" class="phone-label">رقم الهاتف</label>
                    <div class="phone-input-group">
                        <span class="country-code" id="countryCode">+964</span>
                        <input type="tel" wire:model="phone" class="phone-input" id="phone" placeholder="xxx xxxx xxx" aria-labelledby="countryCode phone" required>
                    </div>
                    @error('phone')
                    <div class="error-message" id="phoneError" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="send-code-btn" id="submitBtn" wire:loading.attr="disabled" wire:target="checkPhone">
                    <span wire:loading.remove wire:target="checkPhone" class="btn-text">متابعة</span>
                    <span wire:loading wire:target="checkPhone">
                        <span class="spinner"></span>
                        <span class="btn-text">جاري التحقق...</span>
                    </span>
                </button>
            </form>

            <div class="modal-links">
                <p class="register-link">
                    ليس لديك حساب؟ <a href="#" wire:click.prevent="showRegisterForm">إنشاء حساب جديد</a>
                </p>
            </div>
            @endif

            {{-- STEP 2: إدخال كلمة المرور --}}
            @if ($step === 2)
            <h3 id="modalTitle">مرحباً بعودتك</h3>
            <p>أدخل كلمة المرور</p>

            <form wire:submit.prevent="login">
                <div class="phone-field">
                    <label for="password" class="phone-label">كلمة المرور</label>
                    <div class="password-wrapper">
                        <input type="password" wire:model="password" class="phone-input password-field" id="passwordInput" placeholder="********">
                        <span class="toggle-password" onclick="togglePassword()" aria-label="إظهار/إخفاء كلمة المرور">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                    @error('password')
                    <div class="error-message" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="send-code-btn" wire:loading.attr="disabled" wire:target="login">
                    <span wire:loading.remove wire:target="login" class="btn-text">تسجيل الدخول</span>
                    <span wire:loading wire:target="login">
                        <span class="spinner"></span>
                        <span class="btn-text">جاري الدخول...</span>
                    </span>
                </button>
            </form>

            <div class="modal-links">
                <p class="forgot-link">
                    <a href="#" wire:click.prevent="forgotPassword">هل نسيت كلمة المرور؟</a>
                </p>
            </div>
            @endif

            {{-- STEP 3: إدخال رقم الجوال لاستعادة كلمة المرور --}}
            @if ($step === 3)
            <h3 id="modalTitle">استعادة كلمة المرور</h3>
            <p>أدخل رقم جوالك لاستعادة كلمة المرور</p>

            <form wire:submit.prevent="sendResetCode">
                <div class="phone-field">
                    <label for="reset_phone" class="phone-label">رقم الهاتف</label>
                    <div class="phone-input-group">
                        <span class="country-code">+964</span>
                        <input type="tel" wire:model="reset_phone" class="phone-input" id="reset_phone" placeholder="xxx xxxx xxx" required>
                    </div>
                    @error('reset_phone')
                    <div class="error-message" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="send-code-btn" wire:loading.attr="disabled" wire:target="sendResetCode">
                    <span wire:loading.remove wire:target="sendResetCode" class="btn-text">إرسال الكود</span>
                    <span wire:loading wire:target="sendResetCode">
                        <span class="spinner"></span>
                        <span class="btn-text">جاري الإرسال...</span>
                    </span>
                </button>
            </form>

            <div class="modal-links">
                <p>
                    <a href="#" wire:click.prevent="backToLogin">العودة لتسجيل الدخول</a>
                </p>
            </div>
            @endif

            {{-- STEP 4: إدخال كود التحقق لاستعادة كلمة المرور --}}
            @if ($step === 4)
            <h3 id="modalTitle">تحقق من الكود</h3>
            <p>أدخل كود التحقق المرسل إلى جوالك</p>

            <form wire:submit.prevent="verifyResetCode">
                <div class="phone-field">
                    <label for="reset_code" class="phone-label">كود التحقق</label>
                    <input type="text" wire:model="reset_code" class="phone-input" id="reset_code" placeholder="******" dir="ltr" required maxlength="6">
                    @error('reset_code')
                    <div class="error-message" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="send-code-btn" wire:loading.attr="disabled" wire:target="verifyResetCode">
                    <span wire:loading.remove wire:target="verifyResetCode" class="btn-text">تحقق</span>
                    <span wire:loading wire:target="verifyResetCode">
                        <span class="spinner"></span>
                        <span class="btn-text">جاري التحقق...</span>
                    </span>
                </button>
            </form>

            <div class="modal-links">
                <p>
                    <a href="#" wire:click.prevent="sendResetCode">إعادة إرسال الكود</a>
                </p>
            </div>
            @endif

            {{-- STEP 5: إدخال كلمة مرور جديدة --}}
            @if ($step === 5)
            <h3 id="modalTitle">كلمة مرور جديدة</h3>
            <p>أدخل كلمة المرور الجديدة</p>

            <form wire:submit.prevent="saveNewPassword">
                <div class="phone-field">
                    <label for="new_password" class="phone-label">كلمة المرور الجديدة</label>
                    <input type="password" wire:model="new_password" class="phone-input" id="new_password" placeholder="********" required>
                    @error('new_password')
                    <div class="error-message" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="send-code-btn" wire:loading.attr="disabled" wire:target="saveNewPassword">
                    <span wire:loading.remove wire:target="saveNewPassword" class="btn-text">حفظ كلمة المرور</span>
                    <span wire:loading wire:target="saveNewPassword">
                        <span class="spinner"></span>
                        <span class="btn-text">جاري الحفظ...</span>
                    </span>
                </button>
            </form>
            @endif

            {{-- STEP 6: نموذج إنشاء حساب جديد --}}
            @if ($step === 6)
            <h3 id="modalTitle">إنشاء حساب جديد</h3>
            <p>سجل كبائع في منصة سيّر</p>

            <form wire:submit.prevent="sendRegisterCode">
                <div class="phone-field">
                    <label for="register_name" class="phone-label">الاسم الكامل</label>
                    <input type="text" wire:model="register_name" class="phone-input" id="register_name" placeholder="الاسم الثلاثي" required>
                    @error('register_name')
                    <div class="error-message" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="phone-field">
                    <label for="register_phone" class="phone-label">رقم الهاتف</label>
                    <div class="phone-input-group">
                        <span class="country-code">+964</span>
                        <input type="tel" wire:model="register_phone" class="phone-input" id="register_phone" placeholder="xxx xxxx xxx" required>
                    </div>
                    @error('register_phone')
                    <div class="error-message" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="phone-field">
                    <label for="register_password" class="phone-label">كلمة المرور</label>
                    <input type="password" wire:model="register_password" class="phone-input" id="register_password" placeholder="********" required>
                    @error('register_password')
                    <div class="error-message" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div class="phone-field">
                    <label for="register_password_confirmation" class="phone-label">تأكيد كلمة المرور</label>
                    <input type="password" wire:model="register_password_confirmation" class="phone-input" id="register_password_confirmation" placeholder="********" required>
                </div>

                <button type="submit" class="send-code-btn" wire:loading.attr="disabled" wire:target="sendRegisterCode">
                    <span wire:loading.remove wire:target="sendRegisterCode" class="btn-text">متابعة</span>
                    <span wire:loading wire:target="sendRegisterCode">
                        <span class="spinner"></span>
                        <span class="btn-text">جاري التحقق...</span>
                    </span>
                </button>
            </form>

            <div class="modal-links">
                <p>
                    لديك حساب بالفعل؟ <a href="#" wire:click.prevent="backToLogin">تسجيل الدخول</a>
                </p>
            </div>
            @endif

            {{-- STEP 7: إدخال كود التحقق للتسجيل --}}
            @if ($step === 7)
            <h3 id="modalTitle">تفعيل الحساب</h3>
            <p>أدخل كود التحقق المرسل إلى جوالك</p>

            <form wire:submit.prevent="verifyRegisterCode">
                <div class="phone-field">
                    <label for="register_code" class="phone-label">كود التحقق</label>
                    <input type="text" wire:model="register_code" class="phone-input" id="register_code" placeholder="******" dir="ltr" required maxlength="6">
                    @error('register_code')
                    <div class="error-message" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="send-code-btn" wire:loading.attr="disabled" wire:target="verifyRegisterCode">
                    <span wire:loading.remove wire:target="verifyRegisterCode" class="btn-text">تفعيل الحساب</span>
                    <span wire:loading wire:target="verifyRegisterCode">
                        <span class="spinner"></span>
                        <span class="btn-text">جاري التفعيل...</span>
                    </span>
                </button>
            </form>

            <div class="modal-links">
                <p>
                    لم يصلك الكود؟ <a href="#" wire:click.prevent="resendRegisterCode">إعادة إرسال</a>
                </p>
            </div>
            @endif

            <div class="modal-terms">
                بالتسجيل أنت توافق على <a href="#">الشروط والأحكام</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // مودال
            const openBtn = document.getElementById('openLoginBtn');
            const modal = document.getElementById('loginModal');
            const closeBtn = document.getElementById('closeModalBtn');

            let focusableElementsString = 'a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])';
            let focusableElements, firstFocusable, lastFocusable;

            function openModal() {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    closeBtn.focus();
                    focusableElements = modal.querySelectorAll(focusableElementsString);
                    firstFocusable = focusableElements[0];
                    lastFocusable = focusableElements[focusableElements.length - 1];
                }, 100);
            }

            function closeModal() {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
                openBtn?.focus();
                // إعادة تعيين الخطوات عند الإغلاق (اختياري)
                @this.call('backToLogin');
            }

            if (openBtn) openBtn.addEventListener('click', openModal);

            // استماع لحدث closeModal من Livewire
            window.addEventListener('closeModal', closeModal);

            modal.addEventListener('keydown', (e) => {
                if (e.key === 'Tab') {
                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusable) {
                            e.preventDefault();
                            lastFocusable.focus();
                        }
                    } else {
                        if (document.activeElement === lastFocusable) {
                            e.preventDefault();
                            firstFocusable.focus();
                        }
                    }
                }
                if (e.key === 'Escape') closeModal();
            });

            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            // تحديث focusable elements عند تغيير الخطوات
            Livewire.hook('message.processed', () => {
                setTimeout(() => {
                    focusableElements = modal.querySelectorAll(focusableElementsString);
                    firstFocusable = focusableElements[0];
                    lastFocusable = focusableElements[focusableElements.length - 1];
                    // Focus على أول عنصر في الخطوة الجديدة
                    if (firstFocusable) firstFocusable.focus();
                }, 50);
            });
        });

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
<style>
    /* مودال - متوافق مع التصميم الجديد */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10,26,58,0.8);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .modal.active {
        display: flex;
        opacity: 1;
    }

    .modal-content {
        background: var(--card-bg);
        border-radius: 60px;
        padding: 50px 45px;
        max-width: 480px;
        width: 92%;
        position: relative;
        transform: scale(0.9) translateY(20px);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 50px 80px -30px black;
        text-align: center;
        border-top: 5px solid var(--accent);
    }

    .modal.active .modal-content {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    .modal-close {
        position: absolute;
        top: 20px;
        left: 20px;
        background: var(--gray);
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--text-muted);
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-close:hover {
        background: var(--primary);
        color: white;
        transform: rotate(90deg);
    }

    .modal-icon {
        font-size: 4.375rem;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .modal h3 {
        font-size: 2rem;
        font-weight: 900;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .modal p {
        color: var(--text-muted);
        margin-bottom: 30px;
        font-size: 1rem;
    }

    /* حقول الإدخال */
    .phone-field {
        margin-bottom: 20px;
        text-align: right;
    }

    .phone-label {
        display: block;
        margin-bottom: 8px;
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.9375rem;
    }

    .phone-input-group {
        display: flex;
        align-items: center;
        background: var(--gray-light);
        border: 2px solid var(--gray);
        border-radius: 60px;
        overflow: hidden;
        transition: all 0.3s;
        direction: ltr;
    }

    .phone-input-group:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(10,36,114,0.15);
        background: var(--card-bg);
    }

    .country-code {
        background: var(--card-bg);
        padding: 16px 20px;
        color: var(--primary);
        font-weight: 700;
        font-size: 1rem;
        border-left: 2px solid var(--gray);
    }

    .phone-input {
        flex: 1;
        border: none;
        padding: 16px 15px;
        font-size: 1rem;
        background: transparent;
        outline: none;
        text-align: left;
        color: var(--text-dark);
    }

    /* حقل كلمة المرور */
    .password-wrapper {
        position: relative;
        background: var(--gray-light);
        border: 2px solid var(--gray);
        border-radius: 60px;
        transition: all 0.3s;
        direction: ltr;
    }

    .password-wrapper:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(10,36,114,0.15);
        background: var(--card-bg);
    }

    .password-field {
        border: none !important;
        padding: 16px 15px;
        font-size: 1rem;
        width: 100%;
        background: transparent;
        border-radius: 60px;
        padding-left: 45px;
        color: var(--text-dark);
    }

    .toggle-password {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: var(--text-muted);
        transition: color 0.3s;
    }

    .toggle-password:hover {
        color: var(--primary);
    }

    /* أزرار المودال - بتصميم btn-login */
    .send-code-btn {
        width: 100%;
        padding: 16px 35px;
        background: white;
        color: var(--primary);
        border: 2px solid var(--gray) !important;
        border-radius: var(--border-radius-btn);
        font-size: 1.125rem;
        font-weight: 800;
        cursor: pointer;
        margin: 15px 0 20px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
    }

    .send-code-btn:hover:not(:disabled) {
        background: var(--primary);
        border-color: var(--primary) !important;
        color: white;
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .send-code-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        background: var(--gray);
        border-color: var(--gray) !important;
        color: var(--text-muted);
        transform: none;
        box-shadow: none;
    }

    /* رسائل الخطأ */
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 8px;
        text-align: right;
        min-height: 20px;
        font-weight: 500;
    }

    /* روابط المودال */
    .modal-links {
        margin: 15px 0;
        text-align: center;
    }

    .modal-links a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: border-color 0.3s, color 0.3s;
        font-size: 0.95rem;
    }

    .modal-links a:hover {
        border-bottom-color: var(--primary);
        color: var(--primary-dark);
    }

    .forgot-link,
    .register-link {
        margin: 10px 0;
    }

    /* شروط المودال */
    .modal-terms {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 2px solid var(--gray);
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .modal-terms a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: border-color 0.3s;
    }

    .modal-terms a:hover {
        border-bottom-color: var(--primary);
    }

    /* حالات التحميل */
    .send-code-btn .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    /* حالة التحميل للزر */
    .send-code-btn:has(.spinner) {
        background: var(--primary);
        border-color: var(--primary) !important;
        color: white;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* تأثير Ripple */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.6);
        width: 100px;
        height: 100px;
        margin-top: -50px;
        margin-left: -50px;
        animation: ripple 0.6s linear;
        transform: scale(0);
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* تحسينات للتجاوب */
    @media (max-width: 480px) {
        .modal-content {
            padding: 35px 25px;
        }

        .modal h3 {
            font-size: 1.75rem;
        }

        .send-code-btn {
            padding: 14px 25px;
            font-size: 1rem;
        }

        .phone-input,
        .country-code {
            padding: 14px;
        }

        .modal-icon {
            font-size: 3.5rem;
        }
    }
</style>
    {{-- <style>
             .btn-login {
            background: white;
            color: var(--primary);
            border: 2px solid var(--gray);
            padding: 12px 35px;
            border-radius: var(--border-radius-btn);
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-login:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

    </style> --}}
</div>
