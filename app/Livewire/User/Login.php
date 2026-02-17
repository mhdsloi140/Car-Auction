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
        'phone' => 'required|exists:users,phone',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'phone.required' => 'الرجاء إدخال رقم الجوال',
        'phone.exists' => 'رقم الجوال غير مسجل لدينا',
        'password.required' => 'الرجاء إدخال كلمة المرور',
        'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
    ];

    // التحقق من رقم الهاتف فقط
    public function checkPhone()
    {
        $this->validateOnly('phone');
        $this->step = 2;
    }

    // تسجيل الدخول
    public function login()
    {
        $this->validate();

        if (
            !Auth::attempt([
                'phone' => $this->phone,
                'password' => $this->password,
            ])
        ) {
            $this->addError('password', 'كلمة المرور غير صحيحة');
            return;
        }

        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('seller')) {
            return redirect()->route('seller.dashboard');
        }

        if ($user->hasRole('user')) {
            return redirect()->back();
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
        $this->step = 3;
    }

    public function sendResetCode()
    {
        $this->validate([
            'reset_phone' => 'required|exists:users,phone'
        ], [
            'reset_phone.exists' => 'رقم الجوال غير مسجل لدينا'
        ]);

        // توليد كود
        $this->generated_code = rand(100000, 999999);

        // إرسال الكود عبر واتساب
        $phone = preg_replace('/^0/', '', $this->reset_phone);
        $fullPhone = '00963' . $phone;

        $msg = "كود استعادة كلمة المرور هو: {$this->generated_code}";
        $ultra = new UltraMsgService();
        $ultra->sendMessage($fullPhone, $msg);

        $this->step = 4;
    }

    public function verifyResetCode()
    {
        if ($this->reset_code != $this->generated_code) {
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

        $user = User::where('phone', $this->reset_phone)->first();

        $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        session()->flash('success', 'تم تغيير كلمة المرور بنجاح');

        // العودة لخطوة تسجيل الدخول
        $this->step = 2;
    }

    public function render()
    {
        return view('livewire.user.login')->layout('layouts-users.app');
    }
}
