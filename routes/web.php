<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Mail;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/test-mail', function () {
    try {
        //code...
        Mail::raw('This is a test email', function ($message) {
            $message->to('dharaj.gc@gmail.com')
                ->subject('Test Email');
        });
        return 'Test email sent!';
    } catch (\Throwable $th) {
        dd($th);
    }
});
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    // Artisan::call('storage:link');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    return 'Cache Clear Succesfully...';
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff', [HomeController::class, 'staff_index']);
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'admin_index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:sales'])->group(function () {
    Route::get('/sales', [HomeController::class, 'sales_index'])->name('sales.dashboard');
});
