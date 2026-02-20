<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Services\UltraMsgService;

class Login extends Component
{
    public $step = 1;

    // متغيرات تسجيل الدخول
    public $phone;
    public $password;

    // متغيرات استعادة كلمة المرور
    public $reset_phone;
    public $reset_code;
    public $generated_code;
    public $new_password;

    // متغيرات إنشاء حساب جديد
    public $register_name;
    public $register_phone;
    public $register_password;
    public $register_password_confirmation;
    public $register_code;
    public $register_generated_code;

    protected $rules = [
        'phone'    => 'required|exists:users,phone',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'phone.required'    => 'الرجاء إدخال رقم الجوال',
        'phone.exists'      => 'رقم الجوال غير مسجل لدينا',
        'password.required' => 'الرجاء إدخال كلمة المرور',
        'password.min'      => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
    ];

    // التحقق من رقم الهاتف فقط
    public function checkPhone()
    {
        $this->validateOnly('phone');

        // ✅ التحقق من أن المستخدم غير محظور
        $user = User::where('phone', $this->phone)->first();

        if ($user && $user->status === 'inactive') {
            $this->addError('phone', 'هذا الحساب محظور، يرجى التواصل مع الدعم الفني');
            return;
        }

        $this->step = 2;
    }

    // تسجيل الدخول
    public function login()
    {
        $this->validate();

        // ✅ التحقق من أن المستخدم غير محظور قبل محاولة تسجيل الدخول
        $user = User::where('phone', $this->phone)->first();

        if ($user && $user->status === 'inactive') {
            $this->addError('phone', 'هذا الحساب محظور، يرجى التواصل مع الدعم الفني');
            return;
        }

        if (! Auth::attempt([
            'phone'    => $this->phone,
            'password' => $this->password,
        ])) {
            $this->addError('password', 'كلمة المرور غير صحيحة');
            return;
        }

        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('seller')) {
            return redirect()->route('auction.index');
        }

        if ($user->hasRole('user')) {
            return redirect()->route('home');
        }

        Auth::logout();
        $this->addError('phone', 'غير مسموح لك بتسجيل الدخول من هنا');
    }

    /*
    |--------------------------------------------------------------------------
    |  إنشاء حساب جديد للبائع
    |--------------------------------------------------------------------------
    */

    public function showRegisterForm()
    {
        $this->reset([
            'register_name', 'register_phone', 'register_password',
            'register_password_confirmation', 'register_code', 'register_generated_code'
        ]);
        $this->step = 6;
    }

    public function sendRegisterCode()
    {
        $this->validate([
            'register_name' => 'required|min:3',
            'register_phone' => 'required|unique:users,phone',
            'register_password' => 'required|min:6|confirmed',
            'register_password_confirmation' => 'required'
        ], [
            'register_name.required' => 'الرجاء إدخال الاسم',
            'register_name.min' => 'الاسم يجب أن يكون 3 أحرف على الأقل',
            'register_phone.required' => 'الرجاء إدخال رقم الجوال',
            'register_phone.unique' => 'رقم الجوال مسجل مسبقاً',
            'register_password.required' => 'الرجاء إدخال كلمة المرور',
            'register_password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'register_password.confirmed' => 'كلمة المرور غير متطابقة',
        ]);

        // توليد كود عشوائي من 6 أرقام
        $this->register_generated_code = rand(100000, 999999);

        // حفظ الكود في الجلسة
        session()->put('register_code_' . $this->register_phone, $this->register_generated_code);
        session()->put('register_code_expiry_' . $this->register_phone, now()->addMinutes(10));

        try {
            // إرسال الكود عبر واتساب
            $phone = $this->formatPhoneNumber($this->register_phone);

            if (!$phone) {
                $this->addError('register_phone', 'رقم الجوال غير صحيح');
                return;
            }

            // بناء رسالة الكود
            $message = "📝 *إنشاء حساب جديد - متجر المزادات*\n\n";
            $message .= "مرحباً {$this->register_name}،\n";
            $message .= "كود التحقق الخاص بك هو:\n\n";
            $message .= "🔑 *{$this->register_generated_code}*\n\n";
            $message .= "هذا الكود صالح لمدة 10 دقائق فقط.\n";
            $message .= "يرجى إدخال هذا الكود لتفعيل حسابك.";

            $ultra = new UltraMsgService();
            $result = $ultra->sendMessage($phone, $message);

            if ($result) {
                \Log::info('تم إرسال كود التحقق للتسجيل', ['phone' => $phone]);
            }

            $this->step = 7;

        } catch (\Exception $e) {
            \Log::error('خطأ في إرسال كود التحقق: ' . $e->getMessage());
            $this->addError('register_phone', 'حدث خطأ في إرسال الكود، حاول مرة أخرى');
        }
    }

    public function verifyRegisterCode()
    {
        $this->validate([
            'register_code' => 'required|numeric|digits:6'
        ], [
            'register_code.required' => 'الرجاء إدخال الكود',
            'register_code.numeric' => 'الكود يجب أن يكون أرقام فقط',
            'register_code.digits' => 'الكود يجب أن يكون 6 أرقام'
        ]);

        // التحقق من الكود
        $storedCode = session('register_code_' . $this->register_phone);
        $expiry = session('register_code_expiry_' . $this->register_phone);

        if (!$storedCode || !$expiry || now()->greaterThan($expiry)) {
            $this->addError('register_code', 'الكود منتهي الصلاحية، يرجى طلب كود جديد');
            return;
        }

        if ($this->register_code != $storedCode) {
            $this->addError('register_code', 'الكود غير صحيح');
            return;
        }

        // إنشاء الحساب الجديد
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $this->register_name,
                'phone' => $this->register_phone,
                'password' => Hash::make($this->register_password),
                'status' => 'active',
            ]);

            // تعيين دور البائع
            $user->assignRole('seller');

            DB::commit();

            // حذف الكود من الجلسة
            session()->forget('register_code_' . $this->register_phone);
            session()->forget('register_code_expiry_' . $this->register_phone);

            // إرسال رسالة ترحيب
            $this->sendWelcomeMessage($user);

            // تسجيل الدخول مباشرة
            Auth::login($user);

            session()->flash('success', 'تم إنشاء الحساب بنجاح');

            return redirect()->route('auction.index');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('خطأ في إنشاء حساب جديد: ' . $e->getMessage());
            $this->addError('register_code', 'حدث خطأ في إنشاء الحساب، حاول مرة أخرى');
        }
    }

    public function resendRegisterCode()
    {
        if (!$this->register_phone) {
            return;
        }

        // توليد كود جديد
        $this->register_generated_code = rand(100000, 999999);

        // تحديث الكود في الجلسة
        session()->put('register_code_' . $this->register_phone, $this->register_generated_code);
        session()->put('register_code_expiry_' . $this->register_phone, now()->addMinutes(10));

        try {
            $phone = $this->formatPhoneNumber($this->register_phone);

            if (!$phone) {
                $this->addError('register_phone', 'رقم الجوال غير صحيح');
                return;
            }

            $message = "📝 *إعادة إرسال كود التحقق*\n\n";
            $message .= "مرحباً {$this->register_name}،\n";
            $message .= "كود التحقق الجديد الخاص بك هو:\n\n";
            $message .= "🔑 *{$this->register_generated_code}*\n\n";
            $message .= "هذا الكود صالح لمدة 10 دقائق فقط.";

            $ultra = new UltraMsgService();
            $ultra->sendMessage($phone, $message);

            session()->flash('success', 'تم إرسال كود جديد إلى جوالك');

        } catch (\Exception $e) {
            \Log::error('خطأ في إعادة إرسال الكود: ' . $e->getMessage());
            $this->addError('register_phone', 'حدث خطأ في إرسال الكود');
        }
    }

    /**
     * إرسال رسالة ترحيب بعد التسجيل
     */
    private function sendWelcomeMessage($user)
    {
        try {
            $phone = $this->formatPhoneNumber($user->phone);

            if (!$phone) {
                return;
            }

            $message = "🎉 *مرحباً بك في متجر المزادات*\n\n";
            $message .= "مرحباً {$user->name}،\n";
            $message .= "تم إنشاء حسابك كبائع بنجاح.\n";
            $message .= "يمكنك الآن:\n";
            $message .= "✅ إضافة منتجاتك للمزاد\n";
            $message .= "✅ متابعة المزايدات على منتجاتك\n";
            $message .= "✅ إدارة عروضك بسهولة\n\n";
            $message .= "نتمنى لك تجربة ممتعة وناجحة 🚀";

            $ultra = new UltraMsgService();
            $ultra->sendMessage($phone, $message);

        } catch (\Exception $e) {
            \Log::error('خطأ في إرسال رسالة الترحيب: ' . $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    |  نسيت كلمة المرور
    |--------------------------------------------------------------------------
    */

    public function forgotPassword()
    {
        $this->reset_phone = $this->phone;
        $this->reset_code = '';
        $this->generated_code = '';
        $this->new_password = '';
        $this->step = 3;
    }

    public function sendResetCode()
    {
        $this->validate([
            'reset_phone' => 'required|exists:users,phone'
        ], [
            'reset_phone.required' => 'الرجاء إدخال رقم الجوال',
            'reset_phone.exists' => 'رقم الجوال غير مسجل لدينا'
        ]);

        // ✅ التحقق من أن المستخدم غير محظور
        $user = User::where('phone', $this->reset_phone)->first();

        if ($user && $user->status === 'inactive') {
            $this->addError('reset_phone', 'هذا الحساب محظور، لا يمكن استعادة كلمة المرور');
            return;
        }

        // توليد كود عشوائي من 6 أرقام
        $this->generated_code = rand(100000, 999999);

        // حفظ الكود في الجلسة
        session()->put('reset_code_' . $this->reset_phone, $this->generated_code);
        session()->put('reset_code_expiry_' . $this->reset_phone, now()->addMinutes(10));

        try {
            // إرسال الكود عبر واتساب
            $name = $user ? $user->name : 'المستخدم';
            $phone = $this->formatPhoneNumber($this->reset_phone);

            if (!$phone) {
                $this->addError('reset_phone', 'رقم الجوال غير صحيح');
                return;
            }

            $message = "🔐 *استعادة كلمة المرور*\n\n";
            $message .= "مرحباً {$name}،\n";
            $message .= "كود استعادة كلمة المرور الخاص بك هو:\n\n";
            $message .= "🔑 *{$this->generated_code}*\n\n";
            $message .= "هذا الكود صالح لمدة 10 دقائق فقط.\n";
            $message .= "إذا لم تطلب استعادة كلمة المرور، يرجى تجاهل هذه الرسالة.";

            $ultra = new UltraMsgService();
            $result = $ultra->sendMessage($phone, $message);

            if ($result) {
                \Log::info('تم إرسال كود استعادة كلمة المرور', ['phone' => $phone]);
            }

            $this->step = 4;

        } catch (\Exception $e) {
            \Log::error('خطأ في إرسال كود استعادة كلمة المرور: ' . $e->getMessage());
            $this->addError('reset_phone', 'حدث خطأ في إرسال الكود، حاول مرة أخرى');
        }
    }

    public function verifyResetCode()
    {
        $this->validate([
            'reset_code' => 'required|numeric|digits:6'
        ], [
            'reset_code.required' => 'الرجاء إدخال الكود',
            'reset_code.numeric' => 'الكود يجب أن يكون أرقام فقط',
            'reset_code.digits' => 'الكود يجب أن يكون 6 أرقام'
        ]);

        // التحقق من الكود
        $storedCode = session('reset_code_' . $this->reset_phone);
        $expiry = session('reset_code_expiry_' . $this->reset_phone);

        if (!$storedCode || !$expiry || now()->greaterThan($expiry)) {
            $this->addError('reset_code', 'الكود منتهي الصلاحية، يرجى طلب كود جديد');
            return;
        }

        if ($this->reset_code != $storedCode) {
            $this->addError('reset_code', 'الكود غير صحيح');
            return;
        }

        $this->step = 5;
    }

    public function saveNewPassword()
    {
        $this->validate([
            'new_password' => 'required|min:6'
        ], [
            'new_password.required' => 'الرجاء إدخال كلمة المرور الجديدة',
            'new_password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        ]);

        try {
            $user = User::where('phone', $this->reset_phone)->first();

            if (!$user) {
                $this->addError('reset_phone', 'المستخدم غير موجود');
                return;
            }

            if ($user && $user->status === 'inactive') {
                $this->addError('reset_phone', 'هذا الحساب محظور، لا يمكن تغيير كلمة المرور');
                return;
            }

            $user->update([
                'password' => Hash::make($this->new_password)
            ]);

            session()->forget('reset_code_' . $this->reset_phone);
            session()->forget('reset_code_expiry_' . $this->reset_phone);

            $this->sendConfirmationMessage($user);

            session()->flash('success', 'تم تغيير كلمة المرور بنجاح');

            $this->step = 2;

        } catch (\Exception $e) {
            \Log::error('خطأ في حفظ كلمة المرور الجديدة: ' . $e->getMessage());
            $this->addError('new_password', 'حدث خطأ، حاول مرة أخرى');
        }
    }

    public function backToLogin()
    {
        $this->reset();
        $this->step = 1;
    }

    /**
     * إرسال رسالة تأكيد تغيير كلمة المرور
     */
    private function sendConfirmationMessage($user)
    {
        try {
            $phone = $this->formatPhoneNumber($user->phone);

            if (!$phone) {
                return;
            }

            $message = "✅ *تم تغيير كلمة المرور بنجاح*\n\n";
            $message .= "مرحباً {$user->name}،\n";
            $message .= "تم تغيير كلمة المرور الخاصة بك بنجاح.\n";
            $message .= "يمكنك الآن تسجيل الدخول باستخدام كلمة المرور الجديدة.\n\n";
            $message .= "إذا لم تكن قمت بهذا التغيير، يرجى التواصل مع الدعم الفني فوراً.";

            $ultra = new UltraMsgService();
            $ultra->sendMessage($phone, $message);

        } catch (\Exception $e) {
            \Log::error('خطأ في إرسال رسالة تأكيد تغيير كلمة المرور: ' . $e->getMessage());
        }
    }

    /**
     * تنسيق رقم الهاتف العراقي
     */
    private function formatPhoneNumber($phone)
    {
        if (empty($phone)) {
            return null;
        }

        // إزالة أي أحرف غير رقمية
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // إزالة الصفر الأول إذا وجد
        $phone = ltrim($phone, '0');

        // إزالة 964 إذا كانت موجودة في البداية
        if (str_starts_with($phone, '964')) {
            $phone = substr($phone, 3);
        }

        // التأكد أن الرقم يبدأ بـ 7 (لأرقام العراق)
        if (!str_starts_with($phone, '7')) {
            return null;
        }

        // إضافة رمز العراق 964
        return '964' . $phone;
    }

    public function render()
    {
        return view('livewire.user.login')->layout('layouts-users.app');
    }
}
