<?php
namespace App\Services;

use App\Models\Auction;
use App\Models\Car;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class ProfileBuyerService
{
    ///
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return $user;
    }

   public function update($data)
{
    $user = auth()->user();

    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
      $data['password'] = Hash::make($data['password']);
    }

    $user->update($data);

    return $user;
}







}
