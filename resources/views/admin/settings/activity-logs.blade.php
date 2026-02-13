@extends('layouts.app')

@section('title', 'سجلات النشاطات')

@section('content')

<div class="container my-5" style="direction: rtl; text-align: right;">

    <h3 class="fw-bold mb-4">سجلات النشاطات</h3>
    <form method="GET" action="{{ route('admin.activity.logs') }}" class="mb-4">

    <div class="row g-3">

        <div class="col-md-3">
            <label class="fw-bold">المستخدم</label>
            <input type="text" name="user" class="form-control"
                   value="{{ request('user') }}" placeholder="اسم المستخدم">
        </div>

        <div class="col-md-3">
            <label class="fw-bold">العملية</label>
            <input type="text" name="action" class="form-control"
                   value="{{ request('action') }}" placeholder="نوع العملية">
        </div>

    



        <div class="col-md-3">
            <label class="fw-bold">من تاريخ</label>
            <input type="date" name="from" class="form-control"
                   value="{{ request('from') }}">
        </div>

        <div class="col-md-3">
            <label class="fw-bold">إلى تاريخ</label>
            <input type="date" name="to" class="form-control"
                   value="{{ request('to') }}">
        </div>

    </div>

    <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary px-4">تطبيق الفلترة</button>

        <a href="{{ route('admin.activity.logs') }}" class="btn btn-secondary px-4">
            إعادة التعيين
        </a>
    </div>

</form>


    <form id="delete-form" action="{{ route('admin.activity.logs.delete') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>المستخدم</th>
                            <th>العملية</th>
                            <th>الوصف</th>
                            <th>IP</th>
                            <th>المتصفح</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_logs[]" value="{{ $log->id }}">
                            </td>
                            <td>{{ $log->user->name ?? 'غير معروف' }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->ip }}</td>
                            <td>{{ Str::limit($log->user_agent, 30) }}</td>
                            <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                لا توجد سجلات حتى الآن
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

               <div class="d-flex justify-content-center mt-3">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>

            <div class="p-3 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-danger" id="delete-selected">
                    حذف السجلات المحددة
                </button>

            </div>
        </div>
    </form>

</div>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // تحديد الكل
    document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="selected_logs[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // SweetAlert تأكيد الحذف
    document.getElementById('delete-selected').addEventListener('click', function () {

        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف السجلات المحددة نهائيًا",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'نعم، احذفها',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });

    });
</script>
@endpush
