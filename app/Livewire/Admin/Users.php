<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;

    public $name, $email, $phone, $password, $role, $user_id, $status;
    public $modalFormVisible = false;
    public $isEdit = false;
    public $filterRole = 'all';

    protected function rules()
    {
        return [
            'name'  => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric|unique:users,phone,' . $this->user_id,
            'role'  => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'name.required'  => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email'    => 'البريد الإلكتروني غير صحيح',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.numeric'  => 'رقم الهاتف يجب أن يكون أرقام فقط',
            'phone.unique'   => 'رقم الهاتف مستخدم مسبقًا',
            'role.required'  => 'يجب اختيار الصلاحية',
        ];
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
        $this->email   = $user->email;
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
                'email' => $this->email,
                'phone' => $this->phone,
            ]);

            $user->syncRoles([$this->role]);

        } else {


            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'phone'    => $this->phone,
                'password' => Hash::make('password'),
            ]);

            $user->assignRole($this->role);
        }

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
        $this->email   = '';
        $this->phone   = '';
        $this->password = '';
        $this->role    = '';
        $this->user_id = null;
    }

    public function render()
    {
        $query = User::query();

       
        $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        });

        if ($this->filterRole !== 'all') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', $this->filterRole);
            });
        }

        return view('livewire.admin.users', [
            'users' => $query->paginate(10),
            'roles' => Role::all(),
        ]);
    }
}
