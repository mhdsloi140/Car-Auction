<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\UltraMsgService;

class Login extends Component
{
    public $step = 1;

    public $phone;
    public $password;

    // متغيرات استعادة كلمة المرور
    public $reset_phone;
    public $reset_code;
    public $generated_code;
    public $new_password;

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

        // حفظ الكود في الجلسة (اختياري)
        session()->put('reset_code_' . $this->reset_phone, $this->generated_code);
        session()->put('reset_code_expiry_' . $this->reset_phone, now()->addMinutes(10));

        try {
            // إرسال الكود عبر واتساب
            $name = $user ? $user->name : 'المستخدم';

            // تنسيق رقم الهاتف
            $phone = $this->formatPhoneNumber($this->reset_phone);

            if (!$phone) {
                $this->addError('reset_phone', 'رقم الجوال غير صحيح');
                return;
            }

            // بناء رسالة الكود
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

            // ✅ التحقق من أن المستخدم غير محظور
            if ($user && $user->status === 'inactive') {
                $this->addError('reset_phone', 'هذا الحساب محظور، لا يمكن تغيير كلمة المرور');
                return;
            }

            // تحديث كلمة المرور
            $user->update([
                'password' => Hash::make($this->new_password)
            ]);

            // حذف الكود من الجلسة
            session()->forget('reset_code_' . $this->reset_phone);
            session()->forget('reset_code_expiry_' . $this->reset_phone);

            // إرسال رسالة تأكيد
            $this->sendConfirmationMessage($user);

            session()->flash('success', 'تم تغيير كلمة المرور بنجاح');

            // العودة لخطوة تسجيل الدخول
            $this->step = 2;

        } catch (\Exception $e) {
            \Log::error('خطأ في حفظ كلمة المرور الجديدة: ' . $e->getMessage());
            $this->addError('new_password', 'حدث خطأ، حاول مرة أخرى');
        }
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
