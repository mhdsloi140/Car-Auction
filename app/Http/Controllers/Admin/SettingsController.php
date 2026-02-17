<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {

        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.files', compact('settings'));
    }

    public function save(Request $request)
    {

        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('settings.admin.index')->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}
