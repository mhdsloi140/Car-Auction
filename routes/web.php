<?php

use App\Http\Controllers\Buyer\DashboardController;
use App\Http\Controllers\Buyer\ProfileBuyerController;
use App\Http\Controllers\Seller\AddUserController;
use App\Http\Controllers\User\ProfileUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuctionAdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\SettingsAdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SettingsSecurityController;
use App\Http\Controllers\Seller\AuctionSellersController;
use App\Http\Controllers\Seller\DashboardSellersController;
use App\Http\Controllers\Seller\ProfileSellerController;
use App\Http\Controllers\Users\AuctionUsersController;
use App\Http\Controllers\Users\BidUserController;
use App\Http\Controllers\Users\DashboradUserController;
use App\Http\Livewire\User\Login; // Livewire login

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية للمستخدم العادي
Route::get('/', [DashboradUserController::class, 'index'])->name('home');

// ==================== تسجيل الدخول المشترك ====================
// Route::middleware('guest')->group(function () {
//     Route::get('/login', \App\Livewire\User\Login::class)->name('login'); // Livewire login
// });
Route::get('/login', \App\Livewire\User\Login::class)->name('login');

// ==================== تسجيل الخروج موحد ====================
Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('home');
})->name('logout')->middleware('auth');
// ==================== Seller Routes ====================
Route::prefix('seller')->middleware(['auth', 'role:seller'])->group(function () {
    Route::resource('auction', AuctionSellersController::class);
    Route::get('details/{id}', [AuctionSellersController::class, 'details'])
        ->name('auction.sellers.details');
    Route::get('/auction/{auction}/result', [AuctionSellersController::class, 'result'])->name('auction.sellers.result');
    Route::patch('/{auction}/accept', [AuctionSellersController::class, 'accept'])->name('accept.sellers');
    Route::patch('/{auction}/reject', [AuctionSellersController::class, 'reject'])->name('reject.sellers');
    Route::get('profile', [ProfileSellerController::class, 'index'])->name('seller.profile');
    Route::post('profile', [ProfileSellerController::class, 'update'])->name('seller.profile.update');

    Route::patch('/auction/{auction}/complete', [AuctionSellersController::class, 'complete'])->name('auction.sellers.complete');
    Route::get('add-user', [AddUserController::class, 'index'])->name('sellers.add.user');

});
Route::prefix('buyer')->middleware(['auth', 'role:buyer'])->group(function () {
     Route::get('dashboard', [DashboardController::class, 'index'])->name('buyer.dashboard');
     Route::get('add-user',[DashboardController::class,'create'])->name('buyber.add.user');
      Route::get('profile',[ProfileBuyerController::class,'index'])->name('buyer.profile');
      Route::post('profile',[ProfileBuyerController::class,'update'])->name('buyer.profile.update');
        Route::post('/add-user', [DashboardController::class, 'store'])->name('add-user.store');
});

// ==================== Admin Routes ====================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashbordController::class, 'index'])->name('admin.dashboard');
    Route::resource('brand', BrandController::class);

    Route::get('/auction', [AuctionAdminController::class, 'index'])->name('admin.auction.index');
    Route::get('/auctions/{auction}', [AuctionAdminController::class, 'show'])->name('auction.admin.show');
    Route::patch('/auctions/{id}/approve', [AuctionAdminController::class, 'approve'])->name('auctions.approve');
    Route::patch('/auctions/{id}/reject', [AuctionAdminController::class, 'reject'])->name('auctions.reject');
    Route::delete('/auction/{id}', [AuctionAdminController::class, 'destroy'])->name('auction.admin.destroy');

    Route::get('settings', [SettingsAdminController::class, 'index'])->name('settings.admin.index');
    Route::get('users', [SettingsAdminController::class, 'users'])->name('admin.users.index');
    Route::get('brands', [SettingsAdminController::class, 'brands'])->name('admin.brands.index');
    Route::get('models', [SettingsAdminController::class, 'models'])->name('admin.models.index');

    Route::get('/settings/general', \App\Livewire\Admin\Settings\GeneralSettings::class)->name('admin.settings.general');
    Route::get('/settings/files', [SettingsAdminController::class, 'file'])->name('admin.settings.file');
    Route::get('/settings/security', [SettingsSecurityController::class, 'index'])->name('admin.settings.security');
    Route::post('/settings/security', [SettingsSecurityController::class, 'save'])->name('admin.settings.security.save');
    Route::post('/admin/settings/files', [SettingsController::class, 'save'])->name('admin.settings.save');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity.logs');
    Route::delete('/activity-logs/delete', [ActivityLogController::class, 'delete'])->name('admin.activity.logs.delete');

    Route::get('profile', [ProfileAdminController::class, 'index'])->name('admin.profile');
    Route::post('profile', [ProfileAdminController::class, 'update'])->name('admin.profile.update');

    Route::patch('/auction/{auction}/update-price', [AuctionAdminController::class, 'updatePrice'])->name('auction.update.price');
    Route::get('/auctions/{auction}', [AuctionAdminController::class, 'show'])
        ->whereNumber('auction')
        ->name('auction.admin.show');

    Route::get('/auctions/archive', [AuctionAdminController::class, 'adminArchive'])
        ->name('admin.auctions.archive');
    Route::get('winner/{id}', [AuctionAdminController::class, 'winner'])
        ->name('auction.admin.winner');
    Route::patch('/auction/{auction}/reject', [AuctionAdminController::class, 'reject'])->name('auction.admin.reject');
    Route::get('details/{id}', [AuctionAdminController::class, 'details'])
        ->name('auction.admin.details');
    Route::patch('/auction/{auction}/complete', [AuctionAdminController::class, 'complete'])->name('auction.admin.complete');

});
Route::get('/test-queue', function () {
    \App\Jobs\TestJob::dispatch();
    return 'Job dispatched!';
});
// ==================== Users Auctions Routes ====================
Route::prefix('users')->group(function () {
    Route::get('/auctions/{id}', [AuctionUsersController::class, 'show'])->name('auction.users.show');

    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/auction/{id}/bid', [BidUserController::class, 'show'])->name('auction.bid');
        Route::get('profile', [ProfileUserController::class, 'index'])
            ->name('user.profile');
        Route::post('profile/update', [ProfileUserController::class, 'update'])
            ->name('user.profile.update');
        Route::post('profile/password', [ProfileUserController::class, 'updatePassword'])
            ->name('user.profile.password');
    });

});

Route::get('/download-media/{mediaId}', [App\Http\Controllers\MediaController::class, 'download'])->name('media.download');
