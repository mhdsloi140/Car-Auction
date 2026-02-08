<?php


use App\Http\Controllers\Admin\AuctionAdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SettingsAdminController;
use App\Http\Controllers\Seller\AuctionController;
use App\Http\Controllers\Seller\AuctionSellersController;
use App\Http\Controllers\Seller\AuthController;
use App\Http\Controllers\Users\AuctionUsersController;
use App\Http\Controllers\Users\AuthUserController;
use App\Http\Controllers\Users\DashboradUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboradUserController::class, 'index'])->name('home');


Route::prefix('seller')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('seller.login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('seller.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('seller.logout');
    Route::middleware(['auth', 'role:seller'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Seller\DashbordController::class, 'index'])->name('seller.dashboard');
        Route::resource('auction', AuctionSellersController::class);
        Route::get('details/{id}', [AuctionSellersController::class, 'details'])->name('auction.selles.details');
        // Route::get('/car/{id}/bids', \App\Livewire\Seller\CarDetails::class)->name('auction.selles.details');
    });
});

Route::prefix('admin')->group(function () {

    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])
        ->name('admin.login.submit');
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashbordController::class, 'index'])->name('admin.dashboard');
        Route::resource('brand', BrandController::class);

        Route::get('/auction', [AuctionAdminController::class, 'index'])->name('admin.auction.index');
        Route::get('/auctions/{auction}', [AuctionAdminController::class, 'show'])
            ->name('auction.admin.show');
        Route::patch('/auctions/{id}/approve', [AuctionadminController::class, 'approve'])->name('auctions.approve');
        Route::patch('/auctions/{id}/reject', [AuctionadminController::class, 'reject'])
            ->middleware('permission:reject auction')
            ->name('auctions.reject');
        Route::delete('auction/{id} ', [AuctionAdminController::class, 'destroy'])->name('auction.admin.destroy');
        Route::get('settings', [SettingsAdminController::class, 'index'])->name('admin.settings.index');
        Route::get('users', [SettingsAdminController::class, 'users'])->name('admin.users.index');
        Route::get('brands', [SettingsAdminController::class, 'brands'])->name('admin.brands.index');
        Route::get('models', [SettingsAdminController::class, 'models'])->name('admin.models.index');
        Route::get('/settings/general', \App\Livewire\Admin\Settings\GeneralSettings::class)
            ->name('admin.settings.general');


    });
});
Route::prefix('users')->group(function () {
    Route::post('logout', [AuthUserController::class, 'logout'])->name('logout');
    Route::get('/auctions/{id}', [AuctionUsersController::class, 'show'])
        ->name('auction.users.show');

});
