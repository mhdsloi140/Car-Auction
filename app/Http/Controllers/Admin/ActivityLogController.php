<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->orderBy('id', 'desc')
            ->paginate(20);

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
