<div style="
    max-width:480px;
    margin:auto;
    padding:25px;
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    font-family: 'Tajawal', sans-serif;
">

    <h3 style="
        text-align:center;
        margin-bottom:25px;
        color:#2c3e50;
        font-weight:600;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
    ">
        <i class="bi bi-shop" style="color:#3498db;"></i>
        إضافة معرض جديد
    </h3>

    @if (session()->has('success'))
        <div style="
            background:#27ae60;
            color:white;
            padding:12px 15px;
            margin-bottom:20px;
            border-radius:8px;
            text-align:center;
            font-size:15px;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
        ">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom:15px;">
        <label style="
            display:block;
            margin-bottom:6px;
            color:#34495e;
            font-size:14px;
            font-weight:600;
        ">
            <i class="bi bi-person" style="margin-left:4px;"></i>
            الاسم الكامل
        </label>
        <input type="text"
               wire:model.defer="name"
               placeholder="أدخل الاسم الكامل"
               style="
                   width:100%;
                   padding:12px 15px;
                   border:1px solid #dcdcdc;
                   border-radius:8px;
                   font-size:15px;
                   transition:0.2s;
                   outline:none;
               "
               onfocus="this.style.borderColor='#3498db'"
               onblur="this.style.borderColor='#dcdcdc'">
        @error('name')
            <span style="
                color:#e74c3c;
                font-size:13px;
                margin-top:5px;
                display:block;
                display:flex;
                align-items:center;
                gap:4px;
            ">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $message }}
            </span>
        @enderror
    </div>

    <div style="margin-bottom:20px;">
        <label style="
            display:block;
            margin-bottom:6px;
            color:#34495e;
            font-size:14px;
            font-weight:600;
        ">
            <i class="bi bi-telephone" style="margin-left:4px;"></i>
            رقم الجوال
        </label>
        <input type="tel"
               wire:model.defer="phone"
               placeholder="05xxxxxxxx"
               style="
                   width:100%;
                   padding:12px 15px;
                   border:1px solid #dcdcdc;
                   border-radius:8px;
                   font-size:15px;
                   transition:0.2s;
                   outline:none;
               "
               onfocus="this.style.borderColor='#3498db'"
               onblur="this.style.borderColor='#dcdcdc'">
        @error('phone')
            <span style="
                color:#e74c3c;
                font-size:13px;
                margin-top:5px;
                display:block;
                display:flex;
                align-items:center;
                gap:4px;
            ">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $message }}
            </span>
        @enderror
    </div>

    <div style="
        background:#f8f9fa;
        border-radius:8px;
        padding:12px;
        margin-bottom:20px;
        font-size:13px;
        color:#7f8c8d;
        display:flex;
        align-items:center;
        gap:8px;
    ">
        <i class="bi bi-info-circle" style="color:#3498db;"></i>
        سيتم إنشاء كلمة مرور تلقائية وإرسالها إلى رقم الجوال
    </div>

    <button wire:click="addUser"
            wire:loading.attr="disabled"
            style="
                width:100%;
                padding:14px;
                background:#3498db;
                color:white;
                border:none;
                border-radius:8px;
                cursor:pointer;
                font-size:16px;
                font-weight:600;
                transition:0.3s;
                display:flex;
                align-items:center;
                justify-content:center;
                gap:8px;
            "
            onmouseover="this.style.background='#2980b9'"
            onmouseout="this.style.background='#3498db'"
            onmousedown="this.style.transform='scale(0.98)'"
            onmouseup="this.style.transform='scale(1)'"
    >
        <span wire:loading.remove>
            <i class="bi bi-plus-circle" style="font-size:18px;"></i>
            إضافة المعرض
        </span>
        <span wire:loading>
            <i class="bi bi-arrow-repeat" style="font-size:18px; animation: spin 1s linear infinite;"></i>
            جاري الإضافة...
        </span>
    </button>

    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        input:focus {
            box-shadow: 0 0 0 3px rgba(52,152,219,0.1);
        }
    </style>

</div>
