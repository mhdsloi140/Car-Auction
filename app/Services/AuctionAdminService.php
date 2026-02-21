<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\Car;
use App\Models\User;
use Auth;
use App\Services\UltraMsgService;

class AuctionAdminService
{
    /**
     * عرض جميع المزادات للبائع الحالي
     */
    public function index()
    {
        $seller_id = auth()->user();
        $auctions = Auction::where('seller_id', $seller_id)->paginate(5);

        return $auctions;
    }

    /**
     * عرض تفاصيل مزاد معين
     */
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

    /**
     * الموافقة على المزاد وتفعيله
     */
    public function approve($id)
    {
        $auction = Auction::findOrFail($id);

        $auction->update([
            'status' => 'active',
            'start_at' => now(),
            'end_at' => now()->addDay(),
        ]);

        // إرسال إشعار للبائع
        $this->notifySeller($auction);

        // ✅ إرسال إشعار لجميع المستخدمين
        $this->notifyUsers($auction);

        return $auction;
    }

    /**
     * إرسال إشعار للبائع بأن الطلب قيد المعالجة
     */
    private function notifySeller($auction)
    {
        try {
            $seller = $auction->seller;

            if (!$seller || !$seller->phone) {
                \Log::warning('لا يوجد رقم هاتف للبائع', [
                    'auction_id' => $auction->id,
                    'seller_id' => $auction->seller_id
                ]);
                return;
            }

            \Log::info('جاري إرسال إشعار للبائع', [
                'auction_id' => $auction->id,
                'seller_name' => $seller->name,
                'seller_phone' => $seller->phone
            ]);

            $ultra = app(\App\Services\UltraMsgService::class);

            $message = "🔄 *طلب المزاد قيد المعالجة*\n\n";
            $message .= "مرحباً {$seller->name}،\n\n";

            $message .= "سيتم إعلامك فور انتهاء المعالجه.\n\n";
            $message .= "شكراً لاستخدامك منصتنا 🙏";
            $phone = $ultra->formatPhoneNumber($seller->phone);

            if (!$phone) {
                \Log::warning('رقم البائع غير صالح', [
                    'seller_id' => $seller->id,
                    'phone' => $seller->phone
                ]);
                return;
            }

            $result = $ultra->sendMessage($phone, $message);

            if ($result) {
                \Log::info('تم إرسال إشعار للبائع بنجاح', [
                    'auction_id' => $auction->id,
                    'seller_id' => $seller->id,
                    'phone' => $phone
                ]);
            } else {
                \Log::warning('فشل إرسال إشعار للبائع', [
                    'auction_id' => $auction->id,
                    'seller_id' => $seller->id
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('خطأ في notifySeller: ' . $e->getMessage(), [
                'auction_id' => $auction->id,
                'exception' => $e
            ]);
        }
    }

    /**
     * إرسال إشعار لجميع المستخدمين بوجود مزاد جديد
     */
    private function notifyUsers($auction)
    {
        try {
            // ✅ جلب جميع المستخدمين الذين لديهم role 'user'
            $users = User::role('user')
                ->whereNotNull('phone')
                ->get();

            if ($users->isEmpty()) {
                \Log::info('لا يوجد مستخدمين بأرقام هواتف لإرسال إشعارات لهم');
                return;
            }

            \Log::info('جاري إرسال إشعارات لـ ' . $users->count() . ' مستخدم', [
                'auction_id' => $auction->id
            ]);

            $ultra = app(\App\Services\UltraMsgService::class);

            // ✅ رابط المزاد للمستخدمين
            $auctionUrl = route('auction.show', $auction->id);

            // ✅ تنسيق الرسالة
            $message = "🚗 *مزاد جديد متاح الآن!*\n\n";
            $message .= "📋 *تفاصيل السيارة:*\n";
            $message .= "🚘 الماركة: {$auction->car->brand->name}\n";
            $message .= "🚗 الموديل: {$auction->car->model->name}\n";
            $message .= "📅 السنة: {$auction->car->year}\n";
            $message .= "📍 المدينة: {$auction->car->city}\n";
            $message .= "💰 السعر الابتدائي: " . number_format($auction->starting_price) . " د.ع\n\n";
            $message .= "🔗 *للمشاركة في المزاد:*\n";
            $message .= "اضغط على الرابط:\n{$auctionUrl}\n\n";
            $message .= "⏳ المزاد مستمر لمدة 24 ساعة\n\n";
            $message .= "💰 سارع بالمشاركة!";

            $successCount = 0;
            $failCount = 0;

            // ✅ إرسال الرسالة لكل مستخدم
            foreach ($users as $user) {
                try {
                    $phone = $ultra->formatPhoneNumber($user->phone);

                    if (!$phone) {
                        \Log::warning('رقم المستخدم غير صالح', [
                            'user_id' => $user->id,
                            'phone' => $user->phone
                        ]);
                        $failCount++;
                        continue;
                    }

                    $result = $ultra->sendMessage($phone, $message);

                    if ($result) {
                        $successCount++;
                        \Log::info('تم إرسال إشعار للمستخدم', [
                            'user_id' => $user->id,
                            'phone' => $phone
                        ]);
                    } else {
                        $failCount++;
                        \Log::warning('فشل إرسال إشعار للمستخدم', [
                            'user_id' => $user->id,
                            'phone' => $phone
                        ]);
                    }

                    // ✅ تأخير بسيط بين الرسائل (0.3 ثانية)
                    usleep(300000);

                } catch (\Exception $e) {
                    $failCount++;
                    \Log::error('خطأ في إرسال رسالة لمستخدم', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }

            \Log::info('تم الانتهاء من إرسال الإشعارات', [
                'auction_id' => $auction->id,
                'success' => $successCount,
                'failed' => $failCount,
                'total' => $users->count()
            ]);

        } catch (\Exception $e) {
            \Log::error('خطأ في notifyUsers: ' . $e->getMessage(), [
                'auction_id' => $auction->id,
                'exception' => $e
            ]);
        }
    }

    /**
     * حذف مزاد
     */
    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->delete();

        return $auction;
    }

    /**
     * إكمال المزاد وتحديث الحالة
     */
    public function complete($auction)
    {
        $auction->update(['status' => 'pending_seller']);

        $this->notifySellerCompleted($auction);

        return $auction;
    }
    /**
 * إرسال إشعار للبائع بأن طلبه تمت معالجته مع رابط المزاد
 */
private function notifySellerCompleted($auction)
{
    try {
        $seller = $auction->seller;

        if (!$seller || !$seller->phone) {
            \Log::warning('لا يوجد رقم هاتف للبائع', [
                'auction_id' => $auction->id,
                'seller_id' => $auction->seller_id
            ]);
            return;
        }

        \Log::info('جاري إرسال إشعار للبائع بمعالجة الطلب', [
            'auction_id' => $auction->id,
            'seller_name' => $seller->name,
            'seller_phone' => $seller->phone
        ]);

        $ultra = app(\App\Services\UltraMsgService::class);
        $auctionUrl = route('auction.show', $auction->id);
        $message = "✅ *تمت معالجة طلب المزاد*\n\n";
        $message .= "مرحباً {$seller->name}،\n\n";
        $message .= "تمت معالجة طلب المزاد الخاص بسيارتك:\n";
        $message .= "🔗 *للموافقة على السعر:*\n";
        $message .= "اضغط هنا:\n{$auctionUrl}\n\n";
        $message .= "⚠️ يرجى مراجعة الطلب والموافقة عليه في أقرب وقت.\n\n";
        $message .= "شكراً لاستخدامك منصتنا 🙏";

        $phone = $ultra->formatPhoneNumber($seller->phone);

        if (!$phone) {
            \Log::warning('رقم البائع غير صالح', [
                'seller_id' => $seller->id,
                'phone' => $seller->phone
            ]);
            return;
        }

        $result = $ultra->sendMessage($phone, $message);

        if ($result) {
            \Log::info('تم إرسال إشعار معالجة الطلب للبائع بنجاح', [
                'auction_id' => $auction->id,
                'seller_id' => $seller->id,
                'phone' => $phone
            ]);
        } else {
            \Log::warning('فشل إرسال إشعار معالجة الطلب للبائع', [
                'auction_id' => $auction->id,
                'seller_id' => $seller->id
            ]);
        }

    } catch (\Exception $e) {
        \Log::error('خطأ في notifySellerCompleted: ' . $e->getMessage(), [
            'auction_id' => $auction->id,
            'exception' => $e
        ]);
    }
}
}
