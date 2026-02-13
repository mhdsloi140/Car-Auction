<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
public function index(Request $request)
{
    $logs = ActivityLog::query();

    if ($request->filled('user')) {
        $logs->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->user . '%');
        });
    }

    if ($request->filled('action')) {
        $logs->where('action', 'like', '%' . $request->action . '%');
    }

    if ($request->filled('ip')) {
        $logs->where('ip', 'like', '%' . $request->ip . '%');
    }

    if ($request->filled('agent')) {
        $logs->where('user_agent', 'like', '%' . $request->agent . '%');
    }

    if ($request->filled('from')) {
        $logs->whereDate('created_at', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $logs->whereDate('created_at', '<=', $request->to);
    }

    $logs = $logs->latest()->paginate(20);

    return view('admin.settings.activity-logs', compact('logs'));
}

    public function delete(Request $request)
    {


        if (!$request->has('selected_logs')) {
            return back()->with('error', 'لم يتم اختيار أي سجل للحذف');
        }


        ActivityLog::whereIn('id', $request->selected_logs)->delete();

        return back()->with('success', 'تم حذف السجلات المحددة بنجاح');
    }
}
