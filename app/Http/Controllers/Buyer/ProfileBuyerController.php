<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileBuyerRequset;
use App\Services\ProfileBuyerService;
use Illuminate\Http\Request;

class ProfileBuyerController extends Controller
{
    public function __construct(protected ProfileBuyerService $profileBuyerService)
    {

    }
    public function index()
    {
       $user=$this->profileBuyerService->index();
       return view('buyer.profile.index',compact('user'));
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
    public function update(UpdateProfileBuyerRequset $request)
    {
        $data=$request->validated();
       
        $user=$this->profileBuyerService->update($data);
        return redirect()->route('buyber.add.user')->with('success','تم تحديث الملف الشخصي بنجاح');

    }
}
