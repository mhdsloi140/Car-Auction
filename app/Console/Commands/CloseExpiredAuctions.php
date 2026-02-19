<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\User;
use App\Services\UltraMsgService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CloseExpiredAuctions extends Command
{
    protected $signature = 'auctions:close-expired';
    protected $description = 'Close expired auctions and notify admin';

  public function handle()
{
    $auctions = Auction::where('status', 'active')
        ->where('end_at', '<=', Carbon::now())
        ->with(['car.brand', 'car.model', 'bids'])
        ->get();

    $this->info("تم العثور على {$auctions->count()} مزاد منتهي");
    Log::info("CloseExpiredAuctions: تم العثور على {$auctions->count()} مزاد منتهي");

    foreach ($auctions as $auction) {

        //  تحديد أعلى مزايدة
        $highestBid = $auction->bids()
            ->orderByDesc('amount')
            ->first();

        $winnerId = $highestBid ? $highestBid->user_id : null;

        // تحديث المزاد
        $auction->update([
            'status'     => 'closed',
            'closed_at'  => now(),
            'winner_id'  => $winnerId,
        ]);

        // إشعار الأدمن
        $this->notifyAdmin($auction);

        $this->info("✓ مزاد {$auction->id} انتهى - الفائز: " . ($winnerId ?? 'لا يوجد'));
    }

    return Command::SUCCESS;
}

    /**
     * إرسال إشعار للمدير فقط بانتهاء المزاد
     */
    private function notifyAdmin($auction)
    {
        try {
            // جلب المديرين فقط
            $admins = User::role('admin')
                ->whereNotNull('phone')
                ->get();

            if ($admins->isEmpty()) {
                Log::warning('لا يوجد مديرين بأرقام هواتف');
                return;
            }

            $ultra = app(UltraMsgService::class);

            // رابط المزاد في لوحة المدير
            $adminUrl = route('auction.admin.show', $auction->id);


            $message = "⏰ *مزاد منتهي*\n\n";
            $message .= "📋 *السيارة:*\n";
            $message .= "{$auction->car->brand->name} {$auction->car->model->name} {$auction->car->year}\n";
            $message .= "المدينة: {$auction->car->city}\n\n";
            $message .= "🔗 *للمراجعة:*\n";
            $message .= "{$adminUrl}\n";

            // إرسال لكل مدير
            foreach ($admins as $admin) {
                $phone = $ultra->formatPhoneNumber($admin->phone);
                if ($phone) {
                    $result = $ultra->sendMessage($phone, $message);
                    if ($result) {
                        Log::info("تم إرسال إشعار للمدير {$admin->name} بانتهاء مزاد {$auction->id}");
                    }
                }
            }

        } catch (\Exception $e) {
            Log::error('خطأ في إرسال إشعار للمدير: ' . $e->getMessage());
        }
    }
}
