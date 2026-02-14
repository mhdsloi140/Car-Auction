@extends('layouts.users.app')

@section('content')

<div style="display:flex;justify-content:center;align-items:center;height:100vh;">
    <div style="text-align:center;">
        <h1>منصة Sir</h1>
        <p>نظام تسجيل الدخول الذكي</p>

       <button id="openLoginBtn"
        style="padding:12px 25px;background:#111;color:#fff;border:none;border-radius:10px;">
    تسجيل الدخول
</button>
    </div>
</div>

@livewire('user.login')

@endsection
