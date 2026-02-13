<?php
namespace App\Services;

use App\Models\User;
use Auth;

class AuthAdminService
{
    ///
    public function login($data)
    {

        if (!Auth::attempt(['phone' => $data['phone'], 'password' => $data['password']])) {
        return [
            'status' => false,
            'message' => 'بيانات الدخول غير صحيحة'
        ];
    }

        $user = Auth::user();


        if (!$user->hasRole('admin'))
        {
            Auth::logout();
            return [
                'status' => false,
                'message' => 'ليس لديك صلاحية Admin'
            ];
        }

        if ($user->status !== 'active')
        {
            Auth::logout();
            return [
                'status' => false,
                'message' => 'الحساب غير مفعل أو غير نشط'
            ];
        }
        return [
            'status' => true,
            'user' => $user
        ];
    }
}
