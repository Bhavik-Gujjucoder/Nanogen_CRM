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
use App\Http\Controllers\TargetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrendAnalysisController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SalesPersonController;
use App\Http\Controllers\AreaWiseSalesController;
use App\Http\Controllers\CityManagementController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\GradeManagementController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\StateManagementController;
use App\Http\Controllers\DistributorsDealersController;
use App\Services\SendGridService;

// Route::get('/', function () {
//     return view('welcome');
// });

// →→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→→

Auth::routes();
// Route::get('/test-mail', function () {
//     try {
//         Mail::raw('This is a test email', function ($message) {
//             $message->to('dharaj.gc@gmail.com')
//                 ->subject('Test Email');
//         });
//         return 'Test email sent!';
//     } catch (\Throwable $th) {
//         dd($th);
//     }
// });


Route::get('/test-sendgrid', function (SendGridService $sendGrid) {
    $success = $sendGrid->sendEmail('demon@mailinator.com', 'Test Subject', 'This is a test message via SendGrid API');
    dd( $success);
    return $success ? 'Email sent!' : 'Failed to send email.';
});



Route::get('/test-email', function () {
    // try {
    //      $response = $sendGrid->sendEmail(
    //         'parthb.gc@gmail.com',     // Change to your test email
    //         'Test Email from Laravel',
    //         'This is a test email sent via SendGrid service.'
    //     );
    //     return response()->json([
    //         'status' => method_exists($response, 'statusCode') ? $response->statusCode() : 500,
    //         'body' => method_exists($response, 'body') ? $response->body() : null,
    //     ]);

    //     // return 'Test email sent successfully!';
    // } catch (\Exception $e) {
    //     return 'Error: ' . $e->getMessage();
    // }
     $data = [
            'name' => 'John Doe',
            'message' => 'This is a test email.'
        ];
        try {
            $data["mail_message"] = "Hello!";

            Mail::send('email.mailtest', $data, function ($message) {
                $message
                ->to('bhavikg.gc@gmail.com')
                ->subject('TEST');
            });

            return 'Test email sent successfully!';
        } catch (\Exception $e) {
            dd($e);
            return 'Failed to send test email: ' . $e->getMessage();
        }
});


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('storage:link');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    return 'Cache Clear Succesfully...';
});

Route::middleware(['auth', 'role:super admin,admin'])->group(function () {
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff', [HomeController::class, 'staff_index']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'admin_index'])->name('admin.dashboard');
    Route::get('/get-monthly-report', [HomeController::class, 'monthly_report'])->name('admin.monthly_report');
});

Route::middleware(['auth', 'role:sales'])->group(function () {
    Route::get('/sales', [HomeController::class, 'sales_index'])->name('sales.dashboard');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff', [HomeController::class, 'staff_index'])->name('staff.dashboard');
});

Route::middleware(['auth', 'role:reporting manager'])->group(function () {
    Route::get('/reporting_manager', [HomeController::class, 'reporting_manager_index'])->name('reportingmanager.dashboard');
});

Route::get('/my-profile', [HomeController::class, 'my_profile'])->name('my_profile');

Route::middleware(['auth', 'role:admin,staff,sales,reporting manager'])->group(function () {

    /* Users */
    Route::middleware(['permission:Manage Users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/user/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulkDelete');
    });
    /* Grade */
    Route::middleware(['permission:Grade Management'])->group(function () {
        Route::resource('grade', GradeManagementController::class);
        Route::post('/grade/bulk-delete', [GradeManagementController::class, 'bulkDelete'])->name('grade.bulkDelete');
    });
    /* Category */
    Route::middleware(['permission:Products Category'])->group(function () {
        Route::resource('category', CategoryController::class);
        Route::post('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('category.bulkDelete');
    });
    /* Variation */
    Route::middleware(['permission:Pricing and Product Variation'])->group(function () {
        Route::resource('variation', VariationController::class);
        Route::post('/variation/bulk-delete', [VariationController::class, 'bulkDelete'])->name('variation.bulkDelete');
    });
    /* Product */
    Route::middleware(['permission:Products and Catalogue'])->group(function () {
        Route::resource('product', ProductController::class);
        Route::post('/product/bulk-delete', [ProductController::class, 'bulkDelete'])->name('product.bulkDelete');
    });

    /* Trend Analysis */
    Route::middleware(['permission:Products and Catalogue'])->group(function () {
        Route::get('/trend_analysis/report', [TrendAnalysisController::class, 'product_report'])->name('trend_analysis.product_report');
    }); //{product_id?}

    /* States Management */
    Route::middleware(['permission:State Management'])->group(function () {
        Route::resource('state', StateManagementController::class);
        Route::post('/state/bulk-delete', [StateManagementController::class, 'bulkDelete'])->name('state.bulkDelete');
    });
    /* City Management */
    Route::middleware(['permission:City Management'])->group(function () {
        Route::resource('city', CityManagementController::class);
        Route::post('/city/bulk-delete', [CityManagementController::class, 'bulkDelete'])->name('city.bulkDelete');
    });
    /* Sales Person Details */
    Route::middleware(['permission:Sales Persons'])->group(function () {
        Route::resource('sales_person', SalesPersonController::class);
        Route::post('/sales_person/bulk-delete', [SalesPersonController::class, 'bulkDelete'])->name('sales_person.bulkDelete');
        Route::post('/get-cities', [SalesPersonController::class, 'getCitiesByState'])->name('get.cities');

        Route::get('sales_report/{id}', [SalesPersonController::class, 'sales_report'])->name('sales_person.sales_report');
    });
    /* Area-wise Sales */
    Route::middleware(['permission:Area Wise Sales'])->group(function () {
        Route::resource('area_wise_sales', AreaWiseSalesController::class)->except(['show']);
        Route::get('area_wise_sales/order_show/{id}', [AreaWiseSalesController::class, 'order_show'])->name('area_wise_sales.order_show');
        Route::get('area_wise_sales/show/{city_id}', [AreaWiseSalesController::class, 'show'])->name('area_wise_sales.show');
    });

    /* Distributors & Dealers */
    Route::get('distributors_dealers/index/{dealer?}', [DistributorsDealersController::class, 'index'])->name('distributors_dealers.index');
    Route::get('distributors_dealers/create/{dealer?}', [DistributorsDealersController::class, 'create'])->name('distributors_dealers.create');
    // Route::get('/distributors_dealers/payment_history/{id}', [DistributorsDealersController::class, 'payment_history'])->name('distributors_dealers.payment_history');
    Route::get('/distributors_dealers/export-price-list/{dealer?}', [DistributorsDealersController::class, 'export_price_list'])->name('distributors_dealers.export_price_list');
    Route::get('/replaceInWord/{id}/{dealer?}', [DistributorsDealersController::class, 'replaceInWord'])->name('distributors_dealers.replaceInWord');
    Route::delete('/documents_destroy/{id}', [DistributorsDealersController::class, 'documents_destroy'])->name('distributors_dealers.documents_destroy');
    Route::resource('distributors_dealers', DistributorsDealersController::class)->except(['index', 'create']);

    /* Order Management */
    Route::middleware(['permission:Order Management'])->group(function () {
        Route::post('/order/status-update/{id}', [OrderManagementController::class, 'order_status'])->name('order_management.order_status');
        Route::post('/order/bulk-delete', [OrderManagementController::class, 'bulkDelete'])->name('order_management.bulkDelete');
        Route::resource('order_management', OrderManagementController::class);
    });
    /* Targets */
    Route::middleware(['permission:Targets'])->group(function () {
        Route::post('/target/bulk-delete', [TargetController::class, 'bulkDelete'])->name('target.bulkDelete');
        Route::get('target-quarterly', [TargetController::class, 'target_quarterly'])->name('target.quarterly');
        Route::resource('target', TargetController::class);
    });

    /* Payments */
// Route::resource('payment', PaymentsController::class);

    Route::post('/send-whatsapp-pdf', [WhatsAppController::class, 'sendPdf'])->name('send-whatsapp-pdf.sendPdf');

    /* General Settings */
    Route::middleware(['permission:General Setting'])->group(function () {
        Route::prefix('general-setting')->name('admin.generalsetting')->group(function () {
            Route::get('/create', [GeneralSettingController::class, 'create'])->name('.create');
            Route::post('/store', [GeneralSettingController::class, 'store'])->name('.store');
        });
    });
    /* Complain */
    Route::middleware(['permission:Complain'])->group(function () {
        Route::resource('complain', ComplainController::class);
        Route::post('/complain/bulk-delete', [ComplainController::class, 'bulkDelete'])->name('complain.bulkDelete');
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
