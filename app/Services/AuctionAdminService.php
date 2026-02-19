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
        // dd($auction);
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
        $this->notifyUsers($auction);

        return $auction;
    }
    private function notifyUsers($auction)
    {
        try {
            // جلب جميع المستخدمين الذين لديهم role 'user'
            $users = User::role('user')
                ->whereNotNull('phone')
                ->get();

            if ($users->isEmpty()) {
                \Log::info('لا يوجد مستخدمين بأرقام هواتف');
                return;
            }

            \Log::info('جاري إرسال إشعارات لـ ' . $users->count() . ' مستخدم');

            $ultra = app(\App\Services\UltraMsgService::class);

            // رابط المزاد
            $auctionUrl = route('auction.show', $auction->id);

            // تنسيق الرسالة
            $message = "🚗 *مزاد جديد متاح الآن!*\n\n";
            $message .= "📋 *تفاصيل السيارة:*\n";
            $message .= "الماركة: {$auction->car->brand->name}\n";
            $message .= "الموديل: {$auction->car->model->name}\n";
            $message .= "السنة: {$auction->car->year}\n";
            $message .= "المدينة: {$auction->car->city}\n";
            $message .= "السعر الابتدائي: " . number_format($auction->starting_price) . " د.ع\n\n";
            $message .= "🔗 *للمشاركة في المزاد:*\n";
            $message .= "اضغط على الرابط:\n{$auctionUrl}\n\n";
            $message .= "💰 سارع بالمشاركة!";

            // إرسال الرسالة لكل مستخدم
            foreach ($users as $user) {
                try {
                    $phone = $ultra->formatPhoneNumber($user->phone);

                    if (!$phone) {
                        \Log::warning('رقم غير صالح للمستخدم', [
                            'user_id' => $user->id,
                            'phone' => $user->phone
                        ]);
                        continue;
                    }

                    $result = $ultra->sendMessage($phone, $message);

                    if ($result) {
                        \Log::info('تم إرسال إشعار للمستخدم', [
                            'user_id' => $user->id,
                            'phone' => $phone
                        ]);
                    }

                    // تأخير بسيط بين الرسائل
                    usleep(300000); // 0.3 ثانية

                } catch (\Exception $e) {
                    \Log::error('خطأ في إرسال رسالة لمستخدم', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }

            \Log::info('تم الانتهاء من إرسال الإشعارات للمستخدمين');

        } catch (\Exception $e) {
            \Log::error('خطأ في notifyUsers: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->delete();
        return $auction;
    }

    public function complete($auction)
    {

        $auction->update(['status' => 'pending_seller']);


        $this->notifySeller($auction);
        return $auction;
    }
    private function notifySeller($auction)
    {
        try {
            $seller = $auction->seller;

            if (!$seller || !$seller->phone) {
                \Log::warning('البائع لا يوجد لديه رقم هاتف', ['auction_id' => $auction->id]);
                return;
            }

            $ultra = app(\App\Services\UltraMsgService::class);

            // رابط المزاد للبائع
            $sellerUrl = route('seller.auction.result', $auction->id);

            // تنسيق الرسالة
            $message = "💰 *سعر جديد على سيارتك*\n\n";
            $message .= "📋 *تفاصيل السيارة:*\n";
            $message .= "الماركة: {$auction->car->brand->name}\n";
            $message .= "الموديل: {$auction->car->model->name}\n";
            $message .= "السنة: {$auction->car->year}\n";
            $message .= "المدينة: {$auction->car->city}\n\n";
            $message .= "🏆 *السعر النهائي:*\n";
            $message .= number_format($auction->final_price) . " د.ع\n\n";
            $message .= "🔗 *للمراجعة والقبول:*\n";
            $message .= "اضغط على الرابط:\n{$sellerUrl}\n\n";
            $message .= "⚠️ يرجى مراجعة السعر واتخاذ القرار المناسب.";

            // تنسيق رقم الهاتف وإرسال الرسالة
            $phone = $ultra->formatPhoneNumber($seller->phone);

            if ($phone) {
                $result = $ultra->sendMessage($phone, $message);

                if ($result) {
                    \Log::info("تم إرسال إشعار للبائع {$seller->name} بمزاد {$auction->id}");
                }
            }

        } catch (\Exception $e) {
            \Log::error('خطأ في إرسال إشعار للبائع: ' . $e->getMessage());
        }
    }

}
