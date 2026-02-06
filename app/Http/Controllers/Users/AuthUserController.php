<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    public function login()
    {
        return view('users.auth.index');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('home');
    }
}
