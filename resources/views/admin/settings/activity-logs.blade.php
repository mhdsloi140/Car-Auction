@extends('layouts.app')

@section('title', 'سجلات النشاطات')

@section('content')

<div class="container my-5" style="direction: rtl; text-align: right;">

    <h3 class="fw-bold mb-4">سجلات النشاطات</h3>

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

            <div class="p-3 d-flex justify-content-between align-items-center">
                {{ $logs->links() }}

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
