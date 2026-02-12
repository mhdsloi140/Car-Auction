<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileSellerRequest;
use App\Services\ProfileSellerService;
use Illuminate\Http\Request;

class ProfileSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected ProfileSellerService $profileSellerService)
    {
        //
    }
    public function index()
    {
       $user=$this->profileSellerService->index();
       return view('seller.profile.index',compact('user'));
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
    public function update(UpdateProfileSellerRequest $request)
    {
        $data=$request->validated();
        $user=$this->profileSellerService->update($data);
        return redirect()->back()->with('success','تم تحديث الملف الشخصي بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
