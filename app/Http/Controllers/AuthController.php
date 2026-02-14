<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin() {
    return view('auth.login'); // هنا تستخدم view التي تحتوي على <livewire:auth.login />
}
}
