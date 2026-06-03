<?php

use App\Constants\Acl;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinancialCategoriesController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PartyMenuController;
use App\Http\Controllers\PartyMenuGroupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')->group(function () {

    Route::get('test', function () {
        return response()->json([
            'message' => 'Hello World'
        ]);
    });

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('getUser', 'getUser');
    });

    Route::middleware('auth:api')->group(function () {
        Route::prefix('dashboard')->controller(\App\Http\Controllers\DashboardController::class)->group(function () {
            Route::get('super-admin', 'getSuperAdminDashboard')
                ->middleware('permission:' . Acl::PERMISSION_DASHBOARD_SUPER_ADMIN_READ);
            Route::get('admin', 'getAdminDashboard')
                ->middleware('permission:' . Acl::PERMISSION_DASHBOARD_ADMIN_READ);
            Route::get('sales', 'getSalesDashboard')
                ->middleware('permission:' . Acl::PERMISSION_DASHBOARD_SALES_READ);
        });

        Route::middleware('permission:' . Acl::PERMISSION_SPONSOR_READ)->group(function () {
            Route::get('sponsor/filter-data', [SponsorController::class, 'getFilterData']);
            Route::resource('sponsor', SponsorController::class)->only(['index', 'show']);
        });
        Route::resource('sponsor', SponsorController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_SPONSOR_CREATE);
        Route::resource('sponsor', SponsorController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_SPONSOR_UPDATE);
        Route::resource('sponsor', SponsorController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_SPONSOR_DELETE);

        Route::middleware('permission:' . Acl::PERMISSION_PRODUCT_READ)->group(function () {
            Route::resource('product', ProductController::class)->only(['index', 'show']);
            Route::resource('products', ProductController::class)->only(['index', 'show']);
        });
        Route::resource('product', ProductController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_PRODUCT_CREATE);
        Route::resource('product', ProductController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_PRODUCT_UPDATE);
        Route::resource('product', ProductController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_PRODUCT_DELETE);
        Route::resource('products', ProductController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_PRODUCT_CREATE);
        Route::resource('products', ProductController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_PRODUCT_UPDATE);
        Route::resource('products', ProductController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_PRODUCT_DELETE);

        Route::middleware('permission:' . Acl::PERMISSION_PARTY_READ)->group(function () {
            Route::get('party/related-user', [PartyController::class, 'getPartiesByUser']);
            Route::resource('party', PartyController::class)->only(['index', 'show']);
        });
        Route::post('party/assign-users', [PartyController::class, 'assignUsers'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_ASSIGN_USERS);
        Route::resource('party', PartyController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_CREATE);
        Route::resource('party', PartyController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_UPDATE);
        Route::resource('party', PartyController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_DELETE);

//        Route::post('party-menu/add-products', [PartyMenuController::class, 'addProducts']);
        Route::middleware('permission:' . Acl::PERMISSION_PARTY_MENU_READ)->group(function () {
            Route::resource('party-menu', PartyMenuController::class)->only(['index', 'show']);
        });
        Route::get('party-menu/products', [PartyMenuController::class, 'getProductsByParty'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_MENU_READ . ',' . Acl::PERMISSION_PRODUCT_SELL);
        Route::resource('party-menu', PartyMenuController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_MENU_CREATE);
        Route::resource('party-menu', PartyMenuController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_MENU_UPDATE);
        Route::resource('party-menu', PartyMenuController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_MENU_DELETE);

        Route::resource('party-menu-groups', PartyMenuGroupController::class)->only(['index', 'show'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_MENU_GROUP_READ);
        Route::resource('party-menu-groups', PartyMenuGroupController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_MENU_GROUP_CREATE);
        Route::resource('party-menu-groups', PartyMenuGroupController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_MENU_GROUP_UPDATE);
        Route::resource('party-menu-groups', PartyMenuGroupController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_PARTY_MENU_GROUP_DELETE);

        Route::get('role/users', [RoleController::class, 'getUserWithRoles'])
            ->middleware('permission:' . Acl::PERMISSION_ROLE_READ);
        Route::get('role/permissions', [RoleController::class, 'permissions'])
            ->middleware('permission:' . Acl::PERMISSION_ROLE_READ);
        Route::post('role/users/attach', [RoleController::class, 'attachUsersToRole'])
            ->middleware('permission:' . Acl::PERMISSION_ROLE_ATTACH_USERS);
        Route::resource('role', RoleController::class)->only(['index', 'show'])
            ->middleware('permission:' . Acl::PERMISSION_ROLE_READ);
        Route::resource('role', RoleController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_ROLE_CREATE);
        Route::resource('role', RoleController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_ROLE_UPDATE);
        Route::resource('role', RoleController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_ROLE_DELETE);

        Route::resource('user', UserController::class)->only(['index', 'show'])
            ->middleware('permission:' . Acl::PERMISSION_USER_READ);
        Route::resource('user', UserController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_USER_CREATE);
        Route::resource('user', UserController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_USER_UPDATE);
        Route::resource('user', UserController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_USER_DELETE);

        Route::resource('financial', FinancialController::class)->only(['index', 'show'])
            ->middleware('permission:' . Acl::PERMISSION_FINANCIAL_READ);
        Route::resource('financial', FinancialController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_FINANCIAL_CREATE);
        Route::resource('financial', FinancialController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_FINANCIAL_UPDATE);
        Route::resource('financial', FinancialController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_FINANCIAL_DELETE);

        Route::middleware('permission:' . Acl::PERMISSION_TRANSACTION_READ)->group(function () {
            Route::get('transactions/report', [TransactionsController::class, 'getTransactionReport']);
            Route::resource('transactions', TransactionsController::class)->only(['index', 'show']);
        });
        Route::resource('transactions', TransactionsController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_TRANSACTION_CREATE);
        Route::patch('transactions/{id}/approve', [TransactionsController::class, 'approve'])
            ->middleware('permission:' . Acl::PERMISSION_TRANSACTION_UPDATE);
        Route::patch('transactions/{id}/reject', [TransactionsController::class, 'reject'])
            ->middleware('permission:' . Acl::PERMISSION_TRANSACTION_UPDATE);
        Route::resource('transactions', TransactionsController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_TRANSACTION_UPDATE);
        Route::resource('transactions', TransactionsController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_TRANSACTION_DELETE);

        Route::resource('financial-categories', FinancialCategoriesController::class)->only(['index', 'show'])
            ->middleware('permission:' . Acl::PERMISSION_FINANCIAL_CATEGORY_READ);
        Route::resource('financial-categories', FinancialCategoriesController::class)->only(['store'])
            ->middleware('permission:' . Acl::PERMISSION_FINANCIAL_CATEGORY_CREATE);
        Route::resource('financial-categories', FinancialCategoriesController::class)->only(['update'])
            ->middleware('permission:' . Acl::PERMISSION_FINANCIAL_CATEGORY_UPDATE);
        Route::resource('financial-categories', FinancialCategoriesController::class)->only(['destroy'])
            ->middleware('permission:' . Acl::PERMISSION_FINANCIAL_CATEGORY_DELETE);
    });

});
