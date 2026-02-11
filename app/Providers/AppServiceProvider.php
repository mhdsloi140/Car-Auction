<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Auction;
use App\Observers\AuctionObserver;
use App\Models\Bid;
use App\Observers\BidObserver;
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
    }
}
