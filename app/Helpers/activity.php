<?php
use App\Models\ActivityLog;

function log_activity($action, $description = null)
{
    ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => $action,
        'description' => $description,
        'ip' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
}
