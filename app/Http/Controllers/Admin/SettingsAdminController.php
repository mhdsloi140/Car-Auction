<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        return view('admin.settings.index');
    }
    public function file()
    {
        return view('admin.settings.files');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function users()
    {
        return view('admin.users.index');
    }
    public function brands()
    {
        return view('admin.brands.index');
    }
    public function models()
    {
        return view('admin.models.index');
    }

}
