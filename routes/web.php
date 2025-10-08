<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;

# Admin Controllers
use App\Http\Controllers\Admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\Admin\ManageMaster\UserController as UserAdmin;
use App\Http\Controllers\Admin\ManageMaster\DatasetController as DatasetAdmin;
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
Route::get('/chat/coming-soon', [GuestController::class, 'chat'])->name('chat');
Route::post('/chat', [GuestController::class, 'chatbot'])->name('chatbot');
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
        Route::prefix('dataset')->group(function () {
            Route::get('/', [DatasetAdmin::class, 'index']);
            Route::post('/', [DatasetAdmin::class, 'create']);
            Route::get('all', [DatasetAdmin::class, 'getall']);
            Route::delete('/', [DatasetAdmin::class, 'delete']);
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
