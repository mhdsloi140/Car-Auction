<?php
namespace App\Services;

use App\Models\User;
use Auth;

class AuthSellerService
{
    ///
   public function login($data)
{
    // محاولة تسجيل الدخول
    if (!Auth::attempt(['phone' => $data['phone'], 'password' => $data['password']])) {
        return [
            'status' => false,
            'message' => 'بيانات الدخول غير صحيحة'
        ];
    }

    $user = Auth::user();

    // التحقق من أن المستخدم بائع
    if (!$user->hasRole('seller')) {
        Auth::logout();
        return [
            'status' => false,
            'message' => 'ليس لديك صلاحية seller'
        ];
    }

    // التحقق من حالة الحساب
    if ($user->status !== 'active') {
        Auth::logout();
        return [
            'status' => false,
            'message' => 'الحساب غير مفعل أو غير نشط'
        ];
    }

    // نجاح تسجيل الدخول
    return [
        'status' => true,
        'user' => $user
    ];
}

}
