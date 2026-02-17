<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Services\UltraMsgService;

class Users extends Component
{
    use WithPagination;

    public $name, $phone, $role, $user_id, $status;
    public $modalFormVisible = false;
    public $isEdit = false;
    public $filterRole = 'all';
    

    public $auctionModalVisible = false;
    public $selectedUser;
    public $acceptedAuctionsCount = 0;
    public $rejectedAuctionsCount = 0;

    protected function rules()
    {
        return [
            'name'  => 'required|string',
            'phone' => 'required|numeric|unique:users,phone,' . $this->user_id,
            'role'  => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'name.required'  => 'الاسم مطلوب',
            'phone.numeric'  => 'رقم الهاتف يجب أن يكون أرقام فقط',
            'phone.unique'   => 'رقم الهاتف مستخدم مسبقًا',
            'role.required'  => 'يجب اختيار الصلاحية',
        ];
    }

    private function generatePassword($length = 10)
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    public function showCreateModal()
    {
        $this->resetFields();
        $this->isEdit = false;
        $this->modalFormVisible = true;
    }

    public function showEditModal($id)
    {
        $this->resetFields();
        $this->isEdit = true;

        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name    = $user->name;
        $this->phone   = $user->phone;
        $this->role    = $user->roles->first()?->name;

        $this->modalFormVisible = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            $user = User::findOrFail($this->user_id);
            $user->update([
                'name'  => $this->name,
                'phone' => $this->phone,
            ]);
            $user->syncRoles([$this->role]);
        } else {
            $password = $this->generatePassword(10);
            $user = User::create([
                'name'     => $this->name,
                'phone'    => $this->phone,
                'password' => Hash::make($password),
            ]);
            $user->assignRole($this->role);

            // إرسال كلمة المرور عبر UltraMsg
            $phone = preg_replace('/^0/', '', $this->phone);
            $fullPhone = '00963' . $phone;
            $msg = "مرحباً {$this->name}، تم إنشاء حسابك بنجاح.\nكلمة المرور الخاصة بك هي: {$password}";
            $ultra = new UltraMsgService();
            $ultra->sendMessage($fullPhone, $msg);
        }

        session()->flash('success', 'تم إضافة المستخدم بنجاح وتم إرسال كلمة المرور إلى رقم الجوال');
        $this->modalFormVisible = false;
        $this->resetFields();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
    }

    public function resetFields()
    {
        $this->name    = '';
        $this->phone   = '';
        $this->role    = '';
        $this->user_id = null;
    }

    // عند النقر على اسم البائع لعرض عدد المزادات
    public function showAuctions($userId)
    {
        $this->selectedUser = User::with('auctions')->findOrFail($userId);

        $this->acceptedAuctionsCount = $this->selectedUser->auctions()->where('status','active')->count();
        $this->rejectedAuctionsCount = $this->selectedUser->auctions()->where('status','rejected')->count();

        $this->auctionModalVisible = true;
    }

    public function render()
    {
        $query = User::query();
        $query->whereDoesntHave('roles', fn($q) => $q->where('name','admin'));

        if ($this->filterRole !== 'all') {
            $query->whereHas('roles', fn($q) => $q->where('name',$this->filterRole));
        }

        return view('livewire.admin.users', [
            'users' => $query->paginate(10),
            'roles' => Role::all(),
        ]);
    }
}
