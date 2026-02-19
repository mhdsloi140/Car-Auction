<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use App\Models\Auction;
use App\Observers\AuctionObserver;
use App\Models\Bid;
use App\Observers\BidObserver;
use Illuminate\Http\Client\Factory;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auction::observe(AuctionObserver::class);
        Bid::observe(BidObserver::class);
          Factory::macro('ultraMsg', function () {
            return Http::timeout(30)
                ->retry(3, 2000)
                ->withOptions([
                    'connect_timeout' => 10,
                    'read_timeout' => 30,
                    'timeout' => 30
                ]);
        });
    }
}
