<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UltraMsgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * عرض نموذج إضافة مستخدم
     */
    public function create()
    {
        return view('buyer.add-user');
    }

    /**
     * تخزين المستخدم الجديد
     */
  public function store(Request $request)
{
    // التحقق من صحة البيانات
    $validated = $request->validate([
        'name'      => 'required|string|max:255',
        'phone'     => 'required|numeric|unique:users,phone',
        'latitude'  => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'address'   => 'nullable|string|max:500',
    ], [
        'name.required'      => 'الرجاء إدخال الاسم',
        'name.max'           => 'الاسم طويل جداً',
        'phone.required'     => 'الرجاء إدخال رقم الجوال',
        'phone.numeric'      => 'رقم الجوال يجب أن يكون أرقام فقط',
        'phone.unique'       => 'رقم الجوال مستخدم من قبل',
        'latitude.required'  => 'الرجاء تحديد الموقع على الخريطة',
        'longitude.required' => 'الرجاء تحديد الموقع على الخريطة',
        'latitude.numeric'   => 'خط العرض غير صحيح',
        'longitude.numeric'  => 'خط الطول غير صحيح',
    ]);

    try {
        DB::beginTransaction();

        // توليد كلمة مرور عشوائية
        $password = $this->generatePassword(12);

        // إنشاء المستخدم
        $user = User::create([
            'name'      => $validated['name'],
            'phone'     => $validated['phone'],
            'password'  => Hash::make($password),
            'status'    => 'active',
            'latitude'  => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'address'   => $validated['address'] ?? null,
        ]);

        // تعيين الصلاحية (بائع أو مستخدم عادي)
        $user->assignRole('user'); // أو 'seller' حسب الحاجة

        DB::commit();

        // إرسال رسالة واتساب
        $this->sendWelcomeMessage($user, $password);

        return redirect()->back()->with('success', 'تم اضافة معرض بنجاح وتم ارسال كلمة مرور');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // أخطاء التحقق
        throw $e;

    } catch (\Exception $e) {
        DB::rollBack();

        // تسجيل الخطأ
        Log::error('خطأ في إضافة المستخدم: ' . $e->getMessage(), [
            'file'  => $e->getFile(),
            'line'  => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()
            ->with('error', '❌ حدث خطأ أثناء إضافة المستخدم: ' . $e->getMessage())
            ->withInput();
    }
}

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
     * إرسال رسالة ترحيب عبر واتساب
     */
  private function sendWelcomeMessage($user, $password)
{
    try {
        $formattedPhone = $this->formatPhoneNumber($user->phone);

        if (!$formattedPhone) {
            Log::warning('رقم هاتف غير صالح', ['phone' => $user->phone]);
            return;
        }

        // رابط تسجيل الدخول إلى المنصة
        $loginUrl = route('login'); // إذا كان لديك route name
        // أو استخدم الرابط المباشر
        // $loginUrl = config('app.url') . '/login';
        // $loginUrl = 'https://sir.iq/login';

        // بناء رسالة الترحيب
        $message = "🎉 *مرحباً بك في منصة سَيِّر*\n\n";
        $message .= "تم إنشاء حسابك بنجاح ✅\n\n";
        $message .= "📋 *بيانات الدخول:*\n";
        $message .= "👤 الاسم: {$user->name}\n";
        $message .= "📱 رقم الهاتف: {$user->phone}\n";
        $message .= "🔑 كلمة المرور: `{$password}`\n\n";

        // إضافة معلومات الموقع إذا كانت موجودة


        // إضافة رابط تسجيل الدخول
        $message .= "🔐 *رابط تسجيل الدخول:*\n";
        $message .= "اضغط على الرابط التالي للدخول إلى المنصة:\n";
        $message .= "🔗 {$loginUrl}\n\n";

        $message .= "⚠️ *ملاحظة مهمة:*\n";
        $message .= "ننصحك بتغيير كلمة المرور بعد أول تسجيل دخول للأمان\n\n";

        $message .= "شكراً لانضمامك إلينا 🙏\n";
        $message .= "------------------------\n";
        $message .= "سَيِّر - منصة بيع وشراء السيارات الموثوقة";

        // إرسال الرسالة
        $ultra = new UltraMsgService();
        $result = $ultra->sendMessage($formattedPhone, $message);

        if ($result) {
            Log::info('تم إرسال رسالة الترحيب للمستخدم', ['phone' => $user->phone]);
        } else {
            Log::warning('فشل إرسال رسالة الترحيب للمستخدم', ['phone' => $user->phone]);
        }

    } catch (\Exception $e) {
        Log::error('خطأ في إرسال رسالة الترحيب: ' . $e->getMessage());
    }
}
}
