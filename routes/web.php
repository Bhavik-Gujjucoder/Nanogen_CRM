<?php

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CityManagementController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\GradeManagementController;
use App\Http\Controllers\StateManagementController;

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
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('superadmin.dashboard');
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

Route::middleware(['auth', 'role:admin,staff,sales'])->group(function () {
    /* Users */
    Route::resource('users', UserController::class);

    /* Grade */
    Route::resource('grade', GradeManagementController::class);

    /* Category */
    Route::resource('category', CategoryController::class);
    Route::post('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('product_category.bulk_delete'); //

    /* Variation */
    Route::resource('variation', VariationController::class);
    Route::post('/variation/bulk-delete', [VariationController::class, 'bulkDelete'])->name('variation.bulkDelete');

    /* Product */
    Route::resource('product', ProductController::class);
    Route::post('/product/bulk-delete', [ProductController::class, 'bulkDelete'])->name('product.bulkDelete');

    /* States Management */
    Route::resource('state', StateManagementController::class);
    Route::post('/state/bulk-delete', [StateManagementController::class, 'bulkDelete'])->name('state.bulkDelete');

    /* City Management */
    Route::resource('city', CityManagementController::class);
    Route::post('/city/bulk-delete', [CityManagementController::class, 'bulkDelete'])->name('city.bulkDelete');

    /* General Settings */
    Route::prefix('general-setting')->name('admin.generalsetting')->group(function () {
        Route::get('/create', [GeneralSettingController::class, 'create'])->name('.create');
        Route::post('/store', [GeneralSettingController::class, 'store'])->name('.store');
    });

    Route::post('/variation/get', [VariationController::class, 'get_variation_value'])->name('variation.get');


});

Route::get('/run-composer', function () {
    if (!request()->has('key') || request()->key !== env('APP_KEY')) {
        abort(403, 'Unauthorized action.');
    }

    Artisan::call('composer:dump-autoload');

    return 'Composer Dump Autoload Executed!';
});
