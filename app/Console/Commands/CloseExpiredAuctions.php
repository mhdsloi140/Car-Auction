<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\Notification;
use Carbon\Carbon;

class CloseExpiredAuctions extends Command
{
    protected $signature = 'auctions:close-expired';
    protected $description = 'Close expired auctions and notify users';

    public function handle()
    {
        $auctions = Auction::where('status', 'active')
            ->where('end_at', '<=', Carbon::now())
            ->with(['bids.user', 'car', 'seller'])
            ->get();

        foreach ($auctions as $auction) {

            $highestBid = $auction->bids->sortByDesc('amount')->first();

            $auction->update([
                'status' => 'closed',
                'winner_id' => $highestBid?->user_id,
                'final_price' => $highestBid?->amount,
            ]);

            if ($highestBid) {

                // إشعار البائع
                Notification::create([
                    'user_id' => $auction->seller_id,
                    'title' => 'انتهاء المزاد',
                    'message' => "انتهى مزاد {$auction->car->brand->name} {$auction->car->model->name} والفائز هو {$highestBid->user->name}.",
                    'type' => 'success',
                ]);

                // إشعار الفائز
                Notification::create([
                    'user_id' => $highestBid->user_id,
                    'title' => 'فزت بالمزاد',
                    'message' => "مبروك! فزت بمزاد {$auction->car->brand->name} {$auction->car->model->name}.",
                    'type' => 'success',
                ]);

            } else {

                Notification::create([
                    'user_id' => $auction->seller_id,
                    'title' => 'انتهاء المزاد',
                    'message' => "انتهى مزاد {$auction->car->brand->name} {$auction->car->model->name} بدون مزايدات.",
                    'type' => 'info',
                ]);
            }
        }

        return Command::SUCCESS;
    }
}
