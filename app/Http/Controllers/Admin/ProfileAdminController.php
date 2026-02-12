<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileAdminRequest;
use App\Services\ProfileAdminService;
use Illuminate\Http\Request;

class ProfileAdminController extends Controller
{
    public function __construct(protected ProfileAdminService $profileAdminService)
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=$this->profileAdminService->index();
        return view('admin.profile.index',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileAdminRequest $request)
    {
        $data=$request->validated();
        $user=$this->profileAdminService->update($data);
        return redirect()->back()->with('success','تم تحديث الملف الشخصي بنجاح ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
