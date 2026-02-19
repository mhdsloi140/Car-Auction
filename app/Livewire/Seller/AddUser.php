<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\UltraMsgService;
use Illuminate\Support\Facades\Log;

class AddUser extends Component
{
    public $name;
    public $phone;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|numeric|unique:users,phone',
    ];

    protected $messages = [
        'name.required' => 'الرجاء إدخال الاسم',
        'name.max' => 'الاسم طويل جداً',
        'phone.required' => 'الرجاء إدخال رقم الجوال',
        'phone.numeric' => 'رقم الجوال يجب أن يكون أرقام فقط',
        'phone.unique' => 'رقم الجوال مستخدم من قبل',
    ];

    /**
     * توليد كلمة مرور عشوائية
     */
    private function generatePassword($length = 10): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        return substr(str_shuffle($characters), 0, $length);
    }

    /**
     * تنسيق رقم الهاتف (للأرقام العراقية)
     */
    private function formatPhoneNumber($phone): ?string
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

    /**
     * إضافة مستخدم جديد
     */
    public function addUser()
    {
        $this->validate();

        try {
            // توليد كلمة المرور
            $password = $this->generatePassword(12);

            // إنشاء المستخدم
            $user = User::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'password' => Hash::make($password),
                'status' => 'active', // تفعيل المستخدم مباشرة
            ]);

            // تعيين الصلاحية
            $user->assignRole('user');

            // تنسيق رقم الهاتف وإرسال الرسالة
            $formattedPhone = $this->formatPhoneNumber($this->phone);

            if ($formattedPhone) {
                // بناء رسالة الترحيب
                $message = "🎉 *مرحباً بك في المنصة*\n\n";
                $message .= "تم إنشاء حسابك بنجاح ✅\n\n";
                $message .= "📋 *بيانات الدخول:*\n";
                $message .= "👤 الاسم: {$this->name}\n";
                $message .= "📱 رقم الهاتف: {$this->phone}\n";
                $message .= "🔑 كلمة المرور: `{$password}`\n\n";
                $message .= "🔐 ننصحك بتغيير كلمة المرور بعد أول تسجيل دخول\n\n";
                $message .= "شكراً لانضمامك إلينا 🙏";

                // إرسال الرسالة
                $ultra = new UltraMsgService();
                $result = $ultra->sendMessage($formattedPhone, $message);

                if ($result) {
                    Log::info('تم إرسال رسالة الترحيب للمستخدم', ['phone' => $this->phone]);
                } else {
                    Log::warning('فشل إرسال رسالة الترحيب للمستخدم', ['phone' => $this->phone]);
                }
            } else {
                Log::warning('رقم هاتف غير صالح', ['phone' => $this->phone]);
            }

            // رسالة نجاح للمدير
            session()->flash('success', '✅ تم إضافة المستخدم بنجاح وتم إرسال كلمة المرور إلى جواله');

            // إعادة تعيين الحقول
            $this->reset(['name', 'phone']);

        } catch (\Exception $e) {
            Log::error('خطأ في إضافة المستخدم: ' . $e->getMessage());
            session()->flash('error', '❌ حدث خطأ أثناء إضافة المستخدم');
        }
    }

    public function render()
    {
        return view('livewire.seller.add-user');
    }
}
