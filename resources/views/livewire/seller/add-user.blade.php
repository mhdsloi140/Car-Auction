<div style="
    max-width:480px;
    margin:auto;
    padding:25px;
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    font-family: 'Tajawal', sans-serif;

" >

    <h3 style="text-align:center;margin-bottom:25px;color:#2c3e50;font-weight:600;">
        إضافة مستخدم جديد
    </h3>

    @if (session()->has('success'))
        <div style="
            background:#27ae60;
            color:white;
            padding:12px;
            margin-bottom:20px;
            border-radius:6px;
            text-align:center;
            font-size:15px;
        ">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom:15px;">
        <input type="text" wire:model.defer="name" placeholder="الاسم الكامل"
               style="width:100%;padding:12px;border:1px solid #dcdcdc;border-radius:6px;font-size:15px;">
        @error('name')
            <span style="color:#e74c3c;font-size:13px;">{{ $message }}</span>
        @enderror
    </div>

    <div style="margin-bottom:15px;">
        <input type="text" wire:model.defer="phone" placeholder="رقم الجوال"
               style="width:100%;padding:12px;border:1px solid #dcdcdc;border-radius:6px;font-size:15px;">
        @error('phone')
            <span style="color:#e74c3c;font-size:13px;">{{ $message }}</span>
        @enderror
    </div>



    <button wire:click="addUser" wire:loading.attr="disabled"
            style="
                width:100%;
                padding:12px;
                background:#3498db;
                color:white;
                border:none;
                border-radius:6px;
                cursor:pointer;
                font-size:16px;
                font-weight:600;
                transition:0.2s;
            "
            onmouseover="this.style.background='#2980b9'"
            onmouseout="this.style.background='#3498db'"
    >
        <span wire:loading.remove>إضافة المستخدم</span>
        <span wire:loading>جارٍ الإضافة...</span>
    </button>

</div>
