<?php

use App\Models\Product;
use App\Models\Variation;
use App\Models\DistributorsDealers;
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
use App\Http\Controllers\SalesPersonController;
use App\Http\Controllers\CityManagementController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\GradeManagementController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\StateManagementController;
use App\Http\Controllers\DistributorsDealersController;

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

Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

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
    Route::post('/user/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulkDelete');

    /* Grade */
    Route::resource('grade', GradeManagementController::class);
    Route::post('/grade/bulk-delete', [GradeManagementController::class, 'bulkDelete'])->name('grade.bulkDelete');

    /* Category */
    Route::resource('category', CategoryController::class);
    Route::post('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('category.bulkDelete');

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

    /* Sales Person Details */
    Route::resource('sales_person', SalesPersonController::class);
    Route::post('/sales_person/bulk-delete', [SalesPersonController::class, 'bulkDelete'])->name('sales_person.bulkDelete');
    Route::post('/get-cities', [SalesPersonController::class, 'getCitiesByState'])->name('get.cities');

    /* Distributors & Dealers */
    Route::get('distributors_dealers/index/{dealer?}', [DistributorsDealersController::class, 'index'])->name('distributors_dealers.index');
    Route::get('distributors_dealers/create/{dealer?}', [DistributorsDealersController::class, 'create'])->name('distributors_dealers.create');
    Route::get('/distributors_dealers/payment_history/{id}', [DistributorsDealersController::class, 'payment_history'])->name('distributors_dealers.payment_history');
    Route::resource('distributors_dealers', DistributorsDealersController::class)->except(['index','create']);

    /* Order Management */
    Route::post('/order/status-update/{id}', [OrderManagementController::class, 'order_status'])->name('order_management.order_status');
    Route::post('/order/bulk-delete', [OrderManagementController::class, 'bulkDelete'])->name('order_management.bulkDelete');
    Route::resource('order_management', OrderManagementController::class);

    /* General Settings */
    Route::prefix('general-setting')->name('admin.generalsetting')->group(function () {
        Route::get('/create', [GeneralSettingController::class, 'create'])->name('.create');
        Route::post('/store', [GeneralSettingController::class, 'store'])->name('.store');
    });

    Route::post('/variation/get', [VariationController::class, 'get_variation_value'])->name('variation.get');
    Route::post('/order_product_variation/get', [ProductController::class, 'get_product_variation'])->name('product.variation.get'); 
    Route::post('/order_product_variation_price/get', [ProductController::class, 'get_product_variation_price'])->name('product.variation.price.get'); 


});

Route::get('/run-composer', function () {
    if (!request()->has('key') || request()->key !== env('APP_KEY')) {
        abort(403, 'Unauthorized action.');
    }

    Artisan::call('composer:dump-autoload');

    return 'Composer Dump Autoload Executed!';
});
