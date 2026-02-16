@extends('layouts.app')

@section('content')
<div class="container" dir="rtl">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h4 class="mb-0">الملف الشخصي</h4>
        </div>

        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">الاسم</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name }}">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

            
                <div class="mb-3">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="phone" name="phone" id="phone" class="form-control"
                        value="{{ auth()->user()->phone }}">
                    @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3 position-relative">
                    <label class="form-label">كلمة المرور الحالية</label>

                    <input type="password" name="current_password" id="current_password" class="form-control">

                    <span class="toggle-password" onclick="togglePassword('current_password', this)"
                        style="position:absolute; top:38px; left:10px; cursor:pointer;">
                        <i class="fas fa-eye"></i>
                    </span>

                </div>




                <h5 class="fw-bold">تغيير كلمة المرور</h5>

                <div class="mb-3 position-relative">
                    <label class="form-label">كلمة المرور الجديدة</label>

                    <input type="password" name="password" id="new_password" class="form-control">

                    <span class="toggle-password" onclick="togglePassword('new_password', this)"
                        style="position:absolute; top:38px; left:10px; cursor:pointer;">
                        <i class="fas fa-eye"></i>
                    </span>
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="mb-3 position-relative">
                    <label class="form-label">تأكيد كلمة المرور</label>

                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">

                    <span class="toggle-password" onclick="togglePassword('password_confirmation', this)"
                        style="position:absolute; top:38px; left:10px; cursor:pointer;">
                        <i class="fas fa-eye"></i>
                    </span>
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-primary px-4">حفظ التغييرات</button>

            </form>

        </div>
    </div>

</div>
<script>
    function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);
    const icon = el.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

@endsection
