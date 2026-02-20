@extends('layouts-users.app')

@section('content')
<div class="profile-container fade-up">

    <h2 class="title">
        <i class="fas fa-user-circle"></i>
        الملف الشخصي
    </h2>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- معلومات المستخدم -->
    <div class="profile-box">
        <div class="box-header">
            <i class="fas fa-user-edit"></i>
            <h3>المعلومات الشخصية</h3>
        </div>

        <form method="POST" action="{{ route('user.profile.update') }}">
            @csrf

            <div class="form-group">
                <label>
                    <i class="fas fa-user"></i>
                    الاسم
                </label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" placeholder="أدخل اسمك الكامل">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-phone"></i>
                    رقم الهاتف
                </label>
                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="أدخل رقم هاتفك" dir="ltr">
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i>
                حفظ التعديلات
            </button>
        </form>
    </div>

    <!-- تغيير كلمة المرور -->
    <div class="profile-box">
        <div class="box-header">
            <i class="fas fa-key"></i>
            <h3>تغيير كلمة المرور</h3>
        </div>

        <form method="POST" action="{{ route('user.profile.password') }}">
            @csrf

            <div class="form-group">
                <label>
                    <i class="fas fa-lock"></i>
                    كلمة المرور الجديدة
                </label>
                <input type="password" name="password" placeholder="********">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-lock"></i>
                    تأكيد كلمة المرور
                </label>
                <input type="password" name="password_confirmation" placeholder="********">
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-exchange-alt"></i>
                تغيير كلمة المرور
            </button>
        </form>
    </div>

</div>

<style>
.profile-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.title {
    text-align: center;
    margin-bottom: 30px;
    font-weight: 800;
    font-size: 32px;
    color: #0a1a3a;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.title i {
    color: #0a2472;
    font-size: 40px;
    background: linear-gradient(145deg, #f0f5fe, #ffffff);
    padding: 15px;
    border-radius: 50%;
    box-shadow: 0 10px 25px -10px rgba(10,36,114,0.3);
}

.profile-box {
    background: #ffffff;
    padding: 30px;
    border-radius: 24px;
    margin-bottom: 25px;
    box-shadow: 0 15px 35px -15px rgba(10,36,114,0.15);
    border: 1px solid #e9edf2;
    transition: all 0.3s ease;
}

.profile-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 45px -15px rgba(10,36,114,0.25);
}

.box-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9edf2;
}

.box-header i {
    font-size: 24px;
    color: #0a2472;
    background: rgba(10,36,114,0.08);
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    transition: all 0.3s ease;
}

.profile-box:hover .box-header i {
    background: #0a2472;
    color: white;
}

.box-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #0a1a3a;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-weight: 600;
    color: #2d3e50;
    font-size: 14px;
}

.form-group label i {
    color: #0a2472;
    font-size: 14px;
}

.form-group input {
    width: 100%;
    padding: 14px 16px;
    border-radius: 16px;
    border: 2px solid #e9edf2;
    font-size: 15px;
    transition: all 0.3s ease;
    background: #f8fafd;
    color: #0a1a3a;
}

.form-group input:focus {
    outline: none;
    border-color: #0a2472;
    background: white;
    box-shadow: 0 0 0 4px rgba(10,36,114,0.1);
}

.form-group input[dir="ltr"] {
    text-align: left;
}

.btn-save {
    width: 100%;
    padding: 16px;
    background: linear-gradient(145deg, #0a2472, #12315e);
    color: white;
    border: none;
    border-radius: 20px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 15px;
}

.btn-save:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 30px -10px #0a2472;
    background: linear-gradient(145deg, #12315e, #0a1a3a);
}

.alert-success {
    background: linear-gradient(145deg, #d4edda, #c3e6cb);
    padding: 16px 20px;
    border-radius: 20px;
    margin-bottom: 25px;
    color: #155724;
    text-align: center;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-right: 5px solid #28a745;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success i {
    color: #28a745;
    font-size: 20px;
}

.error {
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
    margin-right: 10px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

.error::before {
    content: '⚠️';
    font-size: 12px;
}

/* Responsive */
@media (max-width: 768px) {
    .profile-container {
        padding: 15px;
    }

    .profile-box {
        padding: 20px;
    }

    .title {
        font-size: 28px;
    }

    .title i {
        font-size: 32px;
        padding: 12px;
    }
}

@media (max-width: 480px) {
    .profile-box {
        padding: 15px;
    }

    .box-header i {
        width: 40px;
        height: 40px;
        font-size: 20px;
    }

    .box-header h3 {
        font-size: 18px;
    }

    .form-group input {
        padding: 12px 14px;
    }

    .btn-save {
        padding: 14px;
    }
}
</style>
@endsection
