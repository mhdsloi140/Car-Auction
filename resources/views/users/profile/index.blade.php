@extends('layouts-users.app')

@section('content')
<div class="profile-container">

    <h2 class="title">الملف الشخصي</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <!-- معلومات المستخدم -->
    <form method="POST" action="{{ route('user.profile.update') }}" class="profile-box">
        @csrf

        <h3>المعلومات الشخصية</h3>

        <label>الاسم</label>
        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>رقم الهاتف</label>
        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
        @error('phone')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn-save">حفظ التعديلات</button>
    </form>

    <!-- تغيير كلمة المرور -->
    <form method="POST" action="{{ route('user.profile.password') }}" class="profile-box">
        @csrf

        <h3>تغيير كلمة المرور</h3>

        <label>كلمة المرور الجديدة</label>
        <input type="password" name="password">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation">

        <button type="submit" class="btn-save">تغيير كلمة المرور</button>
    </form>

</div>

<style>
.profile-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 10px;
}

.title {
    text-align: center;
    margin-bottom: 25px;
    font-weight: 700;
    font-size: 26px;
}

.profile-box {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.profile-box h3 {
    margin-bottom: 15px;
    font-size: 18px;
    font-weight: 600;
}

.profile-box label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

.profile-box input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    margin-bottom: 15px;
    font-size: 15px;
}

.btn-save {
    width: 100%;
    padding: 12px;
    background: #0d6efd;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
}

.btn-save:hover {
    background: #0b5ed7;
}

.alert-success {
    background: #d1e7dd;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    color: #0f5132;
    text-align: center;
}

.error {
    color: #dc3545;
    font-size: 14px;
    margin-top: -10px;
    margin-bottom: 10px;
}
</style>
@endsection
