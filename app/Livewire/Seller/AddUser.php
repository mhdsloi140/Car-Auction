<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

   public function addUser()
{
    $this->validate();

    $user = User::create([
        'name' => $this->name,
        'phone' => $this->phone,
        'password' => Hash::make('  '),
    ]);

    $user->assignRole('user');

    session()->flash('success', 'تم إضافة المستخدم بنجاح');

    $this->reset(['name','phone']);
}

    public function render()
    {
        return view('livewire.seller.add-user');
    }
}
