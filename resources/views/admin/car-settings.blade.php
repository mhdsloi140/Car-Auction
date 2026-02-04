@extends('layouts.app') {{-- أو layout لوحة التحكم عندك --}}

@section('content')
<div class="container-fluid">

    {{-- العنوان --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">إعدادات السيارات</h3>
        <span class="text-muted">الماركات - الموديلات - المواصفات</span>
    </div>

    {{-- التبويبات --}}
    <ul class="nav nav-tabs" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="brands-tab" data-bs-toggle="tab" data-bs-target="#brands"
                type="button" role="tab" aria-controls="brands" aria-selected="true">
                الماركات
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="models-tab" data-bs-toggle="tab" data-bs-target="#models"
                type="button" role="tab" aria-controls="models" aria-selected="false">
                الموديلات
            </button>
        </li>

    </ul>

    <div class="tab-content mt-4">

        {{-- تبويب الماركات --}}
        <div class="tab-pane fade show active" id="brands" role="tabpanel" aria-labelledby="brands-tab">
            @livewire('admin.brands')
        </div>

        {{-- تبويب الموديلات --}}
        <div class="tab-pane fade" id="models" role="tabpanel" aria-labelledby="models-tab">
            {{-- @livewire('admin.car-models') --}}
        </div>

    </div>

</div>
@endsection
