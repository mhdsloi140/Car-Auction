@extends('layouts.app')

@section('content')

<div class="container my-5" style="direction: rtl; text-align: right;">

    <div class="card shadow-sm border-0 rounded-3">

        <div class="card-header bg-light py-3">
            <h4 class="fw-bold mb-0" style="text-align: center">معلومات المستخدم</h4>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <strong class="text-secondary">الاسم:</strong>
                <span class="ms-2">{{ $user->name }}</span>
            </div>

            <div class="mb-3">
                <strong class="text-secondary">البريد الإلكتروني:</strong>
                <span class="ms-2">{{ $user->email }}</span>
            </div>
             <div class="mb-3">
                <strong class="text-secondary"> الهاتف:</strong>
                <span class="ms-2">{{ $user->phone }}</span>
            </div>


        </div>

    </div>

</div>

@endsection
