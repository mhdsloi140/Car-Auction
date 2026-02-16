<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileUserRequest;
use App\Models\User;
use App\Services\ProfileUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileUserController extends Controller
{
    public function __construct(private ProfileUserService $profileUserService){}
    public function index()
    {
     $user_id=auth()->user()->id;
     $user=User::find($user_id);
        return view('users.profile.index',compact('user'));
    }

       public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        return back()->with('success', 'تم تحديث البيانات بنجاح');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}
