<div>

    <button wire:click="confirmDelete" class="btn btn-danger mb-3">
        حذف السجلات المحددة
    </button>

    <table class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" wire:model="selectAll"></th>
                <th>المستخدم</th>
                <th>العملية</th>
                <th>الوصف</th>
                <th>IP</th>
                <th>المتصفح</th>
                <th>التاريخ</th>
            </tr>
        </thead>

        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>
                        <input type="checkbox" wire:model="selectedLogs" value="{{ $log->id }}">
                    </td>
                    <td>{{ $log->user->name ?? 'غير معروف' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->ip }}</td>
                    <td>{{ Str::limit($log->user_agent, 30) }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $logs->links() }}

</div>
