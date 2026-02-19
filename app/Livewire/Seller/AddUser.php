<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\UltraMsgService;

class AddUser extends Component
{
    public $name;
    public $phone;
    public $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|unique:users,phone',

    ];

    protected $messages = [
        'name.required' => 'الرجاء إدخال الاسم',
        'phone.required' => 'الرجاء إدخال رقم الجوال',
        'phone.unique' => 'رقم الجوال مستخدم من قبل',

    ];
    private function generatePassword($length = 10)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    public function addUser()
    {
        $this->validate();
        $password = $this->generatePassword(10);
        $user = User::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'password' => Hash::make($password),
        ]);

        $user->assignRole('user');
        $phone = preg_replace('/^0/', '', $this->phone);
        $fullPhone = '+964' . $phone;
        $msg = "مرحباً {$this->name}، تم إنشاء حسابك بنجاح.\nكلمة المرور الخاصة بك هي: {$password}";
        $ultra = new UltraMsgService();
        $ultra->sendMessage($fullPhone, $msg);
        session()->flash('success', 'تم إضافة المستخدم بنجاح وتم إرسال كلمة المرور إلى جواله');
        $this->reset(['name', 'phone']);
    }


    public function render()
    {
        return view('livewire.seller.add-user');
    }
}
