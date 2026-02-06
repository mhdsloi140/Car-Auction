<?php
namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $step = 1;
    public $phone;
    public $password;

    protected function rules()
    {
        return [
            'phone' => 'required|exists:users,phone',
            'password' => 'required|min:6',
        ];
    }

    public function checkPhone()
    {
        $this->validateOnly('phone');
        $this->step = 2;
    }

public function login()
{
    $this->validate();

    if (Auth::attempt([
        'phone' => $this->phone,
        'password' => $this->password,
    ])) {

        if (! auth()->user()->hasRole('user')) {
            Auth::logout();
            $this->addError('phone', 'غير مسموح لك بتسجيل الدخول من هنا');
            return;
        }

        return redirect()->to('/');
    }

    $this->addError('password', 'كلمة المرور غير صحيحة');
}


    public function render()
    {
        return view('livewire.user.login');
    }
}
