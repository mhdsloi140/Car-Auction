<?php
namespace App\Services;

use App\Models\Auction;
use App\Models\Car;
use App\Models\User;
use Auth;
use App\Services\UltraMsgService;



class AuctionAdminService
{
    ///
    public function index()
    {
        $seller_id = auth()->user();
        $auctions = Auction::where('seller_id', $seller_id)->paginate(5);
        return $auctions;
    }


    public function show($id)
    {
        $auction = Auction::with([
            'car.brand',
            'car.model',
            'seller',
            'car.media',
        ])->findOrFail($id);

        return $auction;
    }
public function approve($id)
{
    $auction = Auction::findOrFail($id);

    // تحديث حالة المزاد
    $auction->update([
        'status' => 'active',
        'start_at' => now(),
        'end_at' => now()->addDay(),
    ]);

    // رابط المزاد
    $url = route('auction.show', $auction->id);

    // خدمة الإرسال
    $ultra = new UltraMsgService();

    /*
    |--------------------------------------------------------------------------
    | 1) إرسال رسالة لصاحب المزاد
    |--------------------------------------------------------------------------
    */

    if ($auction->user && $auction->user->phone) {

        $phone = preg_replace('/^0/', '', $auction->user->phone);
        $fullPhone = '00963' . $phone; 

        $msgOwner = "مرحباً {$auction->user->name}،\nتمت الموافقة على مزادك.\nرابط المزاد:\n{$url}";

        $ultra->sendMessage($fullPhone, $msgOwner);
    }


    $users = User::role('user')->get();

    foreach ($users as $user) {

        if (!$user->phone) continue;

        $phone = preg_replace('/^0/', '', $user->phone);
        $fullPhone = '+966' . $phone;

        $msgUsers = "يوجد مزاد جديد الآن!\nرابط المزاد:\n{$url}";

        $ultra->sendMessage($fullPhone, $msgUsers);
    }

    return $auction;
}

    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->delete();
        return $auction;
    }


}
