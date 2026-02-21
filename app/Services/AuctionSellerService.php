<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AuctionSellerService
{
    /**
     * جلب قائمة المزادات للبائع الحالي
     */
    public function index()
    {
        $sellerId = auth()->id();

        $auctions = Auction::with(['car.brand', 'car.model', 'car.media'])
            ->where('seller_id', $sellerId)
            ->paginate(5);

        return $auctions;
    }

    /**
     * عرض مزاد معين مع السيارة والبائع
     */
    public function show($auctionId)
    {
        $auction = Auction::with(['car.brand', 'car.model', 'car.media', 'seller'])
            ->findOrFail($auctionId);

        return $auction;
    }

    /**
     * قبول سعر المزاد
     */
/**
 * قبول سعر المزاد
 */
public function accept($auction)
{
    // التأكد أن المستخدم هو البائع
    if (Auth::id() !== $auction->seller_id) {
        return [
            'success' => false,
            'message' => 'غير مصرح لك'
        ];
    }

    // التأكد أن المزاد في حالة pending_seller
    if ($auction->status !== 'pending_seller') {
        return [
            'success' => false,
            'message' => 'هذا المزاد ليس بانتظار قرارك'
        ];
    }

    try {
        // تحديث حالة المزاد
        $auction->update([
            'status' => 'completed',
            'seller_decision_at' => now(),
        ]);

        // تسجيل النشاط
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'قبول سعر المزاد',
            'description' => "قام البائع بقبول سعر المزاد رقم {$auction->id} بقيمة {$auction->final_price}",
            'auction_id' => $auction->id,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Log::info('بائع قبل المزاد', [
            'auction_id' => $auction->id,
            'seller_id' => Auth::id()
        ]);

        // ✅ إرسال إشعار للمدير بقبول البائع
        $this->notifyAdmin($auction, 'accept');

        return [
            'success' => true,
            'message' => 'تم قبول السعر بنجاح'
        ];

    } catch (\Exception $e) {
        Log::error('خطأ في قبول المزاد', [
            'auction_id' => $auction->id,
            'error' => $e->getMessage()
        ]);

        return [
            'success' => false,
            'message' => 'حدث خطأ أثناء قبول السعر'
        ];
    }
}

/**
 * رفض سعر المزاد
 */
public function reject($auction)
{
    // التأكد أن المستخدم هو البائع
    if (Auth::id() !== $auction->seller_id) {
        return [
            'success' => false,
            'message' => 'غير مصرح لك'
        ];
    }

    // التأكد أن المزاد في حالة pending_seller
    if ($auction->status !== 'pending_seller') {
        return [
            'success' => false,
            'message' => 'هذا المزاد ليس بانتظار قرارك'
        ];
    }

    try {
        // تحديث حالة المزاد
        $auction->update([
            'status' => 'rejected',
            'seller_decision_at' => now(),
        ]);

        // تسجيل النشاط
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'رفض سعر المزاد',
            'description' => "قام البائع برفض سعر المزاد رقم {$auction->id}",
            'auction_id' => $auction->id,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Log::info('بائع رفض المزاد', [
            'auction_id' => $auction->id,
            'seller_id' => Auth::id(),
        ]);

        // ✅ إرسال إشعار للمدير برفض البائع
        $this->notifyAdmin($auction, 'reject');

        return [
            'success' => true,
            'message' => 'تم رفض السعر'
        ];

    } catch (\Exception $e) {
        Log::error('خطأ في رفض المزاد', [
            'auction_id' => $auction->id,
            'error' => $e->getMessage()
        ]);

        return [
            'success' => false,
            'message' => 'حدث خطأ أثناء رفض السعر'
        ];
    }
}

/**
 * إرسال إشعار للمدير بقرار البائع
 */
private function notifyAdmin($auction, $decision)
{
    try {
        // جلب جميع المديرين
        $admins = User::role('admin')
            ->whereNotNull('phone')
            ->get();

        if ($admins->isEmpty()) {
            Log::warning('لا يوجد مديرين بأرقام هواتف لإرسال الإشعار');
            return;
        }

        $ultra = app(UltraMsgService::class);

        // رابط المزاد في لوحة المدير
        $adminUrl = route('auction.admin.show', $auction->id);

        // تنسيق الرسالة حسب القرار
        if ($decision === 'accept') {
            $decisionText = "✅ قبول";
            $decisionColor = "success";
            $messageTitle = "💰 قبول البائع للسعر";
        } else {
            $decisionText = "❌ رفض";
            $decisionColor = "danger";
            $messageTitle = "💰 رفض البائع للسعر";
        }

        // بناء الرسالة
        $message = "{$messageTitle}\n\n";


        $message .= "🏷️ *السعر النهائي:* " . number_format($auction->current_price) . " د.ع\n\n";

        $message .= "👤 *البائع:*\n";
        $message .= "الاسم: {$auction->seller->name}\n";
        $message .= "رقم الهاتف: {$auction->seller->phone}\n\n";

        $message .= "📌 *قرار البائع:* {$decisionText}\n\n";

        $message .= "🔗 *للمراجعة:*\n";
        $message .= "اضغط على الرابط:\n{$adminUrl}";

        // إرسال الرسالة لكل مدير
        foreach ($admins as $admin) {
            $phone = $this->formatPhoneNumber($admin->phone);
            if ($phone) {
                $ultra->sendMessage($phone, $message);
                Log::info("تم إرسال إشعار للمدير {$admin->name} بقرار {$decision} للمزاد {$auction->id}");
            }
        }

    } catch (\Exception $e) {
        Log::error('خطأ في إرسال إشعار للمدير: ' . $e->getMessage());
    }
}

/**
 * تنسيق رقم الهاتف العراقي
 */
private function formatPhoneNumber($phone)
{
    if (empty($phone)) {
        return null;
    }

    // إزالة أي أحرف غير رقمية
    $phone = preg_replace('/[^0-9]/', '', $phone);

    // إزالة الصفر الأول إذا وجد
    $phone = ltrim($phone, '0');

    // إزالة 964 إذا كانت موجودة في البداية
    if (str_starts_with($phone, '964')) {
        $phone = substr($phone, 3);
    }

    // التأكد أن الرقم يبدأ بـ 7 (لأرقام العراق)
    if (!str_starts_with($phone, '7')) {
        return null;
    }

    // إضافة رمز العراق 964
    return '964' . $phone;
}
}
