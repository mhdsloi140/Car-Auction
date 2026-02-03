<?php
namespace App\Services;

use App\Models\User;
use Auth;

class AuthSellerService
{
    ///
    public function login($data)
    {

        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return [
                'status' => false,
                'message' => 'بيانات الدخول غير صحيحة'
            ];
        }

        $user = Auth::user();


        if (!$user->hasRole(roles: 'seller'))
        {
            Auth::logout();
            return [
                'status' => false,
                'message' => 'ليس لديك صلاحية seller'
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
