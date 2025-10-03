<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;

# Admin Controllers
use App\Http\Controllers\Admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\Admin\ManageMaster\UserController as UserAdmin;
use App\Http\Controllers\Admin\ManageMaster\CategoryController as CategoryAdmin;
# Sales Controllers
use App\Http\Controllers\Sales\DashboardController as DashboardSales;
use App\Http\Controllers\Sales\ManageMaster\CategoryController as CategorySales;

/*
|--------------------------------------------------------------------------
| Web Routes develop by kuli it tecno
|--------------------------------------------------------------------------
*/

# -------------------- AUTH --------------------
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

# -------------------- Guest --------------------
Route::get('/', [GuestController::class, 'home'])->name('home');
Route::get('/coming-soon', [GuestController::class, 'comingsoon'])->name('comingsoon');

# -------------------- ADMIN --------------------
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    # Dashboard
    Route::get('/', [DashboardAdmin::class, 'index']);

    # Manage Data Member
    Route::prefix('manage-master')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserAdmin::class, 'index']);
            Route::post('/', [UserAdmin::class, 'create']);
            Route::get('all', [UserAdmin::class, 'getall']);
            Route::post('get', [UserAdmin::class, 'get']);
            Route::post('update', [UserAdmin::class, 'update']);
            Route::delete('/', [UserAdmin::class, 'delete']);
        });
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryAdmin::class, 'index']);
            Route::post('/', [CategoryAdmin::class, 'create']);
            Route::get('all', [CategoryAdmin::class, 'getall']);
            Route::post('get', [CategoryAdmin::class, 'get']);
            Route::post('update', [CategoryAdmin::class, 'update']);
            Route::delete('/', [CategoryAdmin::class, 'delete']);
        });
    });

   
});

# -------------------- SALES --------------------
Route::prefix('sales')->middleware(['auth', 'role:sales'])->group(function () {
    # Dashboard
    Route::get('/', [DashboardSales::class, 'index']);

    # Manage Data Member
    Route::prefix('manage-master')->group(function () {
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategorySales::class, 'index']);
            Route::post('/', [CategorySales::class, 'create']);
            Route::get('all', [CategorySales::class, 'getall']);
            Route::post('get', [CategorySales::class, 'get']);
            Route::post('update', [CategorySales::class, 'update']);
            Route::delete('/', [CategorySales::class, 'delete']);
        });
        
    });

    
});
