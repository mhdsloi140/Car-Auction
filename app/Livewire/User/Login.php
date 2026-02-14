<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $step = 1;
    public $phone;
    public $password;

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

    // تحقق رقم الهاتف فقط
    public function checkPhone()
    {
        $this->validateOnly('phone');
        $this->step = 2;
    }

    // تسجيل الدخول
    public function login()
    {
        $this->validate();

        if (! Auth::attempt([
            'phone'    => $this->phone,
            'password' => $this->password,
        ])) {
            $this->addError('password', 'كلمة المرور غير صحيحة');
            return;
        }

        $user = auth()->user();

        // توجيه حسب الدور
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('seller')) {
            return redirect()->route('seller.dashboard');
        }

        if ($user->hasRole('user')) {
            return redirect()->route('home');
        }

        // إذا لم يكن له أي دور معروف
        Auth::logout();
        $this->addError('phone', 'غير مسموح لك بتسجيل الدخول من هنا');
    }

  public function render()
{
    return view('livewire.user.login')->layout('layouts-users.app');
}
}
