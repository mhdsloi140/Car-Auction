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

    // ✅ المتغيرات الجديدة للمودالات
    public $deleteModalVisible = false;
    public $blockModalVisible = false;
    public $unblockModalVisible = false;
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
            session()->flash('success', 'تم تحديث المستخدم بنجاح');
        } else {
            $password = $this->generatePassword(10);
            $user = User::create([
                'name'     => $this->name,
                'phone'    => $this->phone,
                'password' => Hash::make($password),
            ]);
            $user->assignRole($this->role);

            // ✅ إرسال كلمة المرور عبر UltraMsg
            $this->sendWelcomeMessage($user, $password);

            session()->flash('success', 'تم إضافة المستخدم بنجاح وتم إرسال كلمة المرور إلى رقم الجوال');
        }

        $this->modalFormVisible = false;
        $this->resetFields();
    }

    /**
     * إرسال رسالة ترحيب للمستخدم الجديد مع كلمة المرور
     */
    private function sendWelcomeMessage($user, $password)
    {
        try {
            // تنسيق رقم الهاتف (أرقام عراقية)
            $phone = $this->formatPhoneNumber($user->phone);

            if (!$phone) {
                \Log::warning('رقم هاتف غير صالح للمستخدم', ['user_id' => $user->id, 'phone' => $user->phone]);
                return;
            }

            // تنسيق اسم الدور بالعربية
            $roleName = match($user->roles->first()?->name) {
                'admin' => 'مدير',
                'seller' => 'بائع',
                'user' => 'معرض',
                default => 'مستخدم'
            };

            // بناء الرسالة
            $message = " *مرحباً بك في منصة سَيِّر SIR*\n\n";
            $message .= "تم إنشاء حسابك بنجاح ✅\n\n";
            $message .= " *بيانات الدخول:*\n";
            $message .= " الاسم: {$user->name}\n";
            $message .= " رقم الهاتف: {$user->phone}\n";
            $message .= " كلمة المرور: `{$password}`\n";
            $message .= " الصلاحية: {$roleName}\n\n";
            $message .= "🔐 ننصحك بتغيير كلمة المرور بعد أول تسجيل دخول\n\n";
            $message .= "شكراً لانضمامك إلينا 🙏";

            // إرسال الرسالة
            $ultra = new UltraMsgService();
            $result = $ultra->sendMessage($phone, $message);

            if ($result) {
                \Log::info('تم إرسال رسالة الترحيب بنجاح', ['user_id' => $user->id, 'phone' => $phone]);
            } else {
                \Log::warning('فشل إرسال رسالة الترحيب', ['user_id' => $user->id, 'phone' => $phone]);
            }

        } catch (\Exception $e) {
            \Log::error('خطأ في إرسال رسالة الترحيب: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
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

    // ✅ دالة تأكيد الحذف
    public function confirmDelete($id)
    {
        $this->selectedUser = User::findOrFail($id);
        $this->deleteModalVisible = true;
    }

    // ✅ دالة تنفيذ الحذف
    public function confirmDeleteAction()
    {
        if ($this->selectedUser) {
            $this->selectedUser->delete();
            $this->deleteModalVisible = false;
            $this->selectedUser = null;
            session()->flash('success', 'تم حذف المستخدم بنجاح');
        }
    }

    // ✅ دالة تأكيد الحظر
    public function confirmBlock($id)
    {
        $this->selectedUser = User::findOrFail($id);
        $this->blockModalVisible = true;
    }

    // ✅ دالة تنفيذ الحظر
    public function confirmBlockAction()
    {
        if ($this->selectedUser) {
            $this->selectedUser->status = 'inactive';
            $this->selectedUser->save();
            $this->blockModalVisible = false;
            $this->selectedUser = null;
            session()->flash('success', 'تم حظر المستخدم بنجاح');
        }
    }

    // ✅ دالة تأكيد إلغاء الحظر
    public function confirmUnblock($id)
    {
        $this->selectedUser = User::findOrFail($id);
        $this->unblockModalVisible = true;
    }

    // ✅ دالة تنفيذ إلغاء الحظر
    public function confirmUnblockAction()
    {
        if ($this->selectedUser) {
            $this->selectedUser->status = 'active';
            $this->selectedUser->save();
            $this->unblockModalVisible = false;
            $this->selectedUser = null;
            session()->flash('success', 'تم إلغاء حظر المستخدم بنجاح');
        }
    }

    // عند النقر على اسم المستخدم لعرض عدد المزادات
    public function showAuctions($userId)
    {
        $this->selectedUser = User::with('auctions')->findOrFail($userId);
        $this->acceptedAuctionsCount = $this->selectedUser->auctions()->where('status', 'active')->count();
        $this->rejectedAuctionsCount = $this->selectedUser->auctions()->where('status', 'rejected')->count();
        $this->auctionModalVisible = true;
    }

    public function resetFields()
    {
        $this->name    = '';
        $this->phone   = '';
        $this->role    = '';
        $this->user_id = null;
    }

    public function render()
    {
        $query = User::query();
        $query->whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'));

        if ($this->filterRole !== 'all') {
            $query->whereHas('roles', fn($q) => $q->where('name', $this->filterRole));
        }

        return view('livewire.admin.users', [
            'users' => $query->paginate(10),
            'roles' => Role::all(),
        ]);
    }
}
