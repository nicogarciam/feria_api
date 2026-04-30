<?php

use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\ImageAPIController;
use App\Http\Controllers\API\MovementAPIController;
use App\Http\Controllers\API\PaymentAPIController;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\ProviderAPIController;
use App\Http\Controllers\API\SaleAPIController;
use App\Http\Controllers\API\SaleStateAPIController;
use App\Http\Controllers\API\StoreAPIController;
use App\Http\Controllers\API\SettlementAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('certificados', 'App\Http\Controllers\API\ProductAPIController@index');

Route::get('test', 'App\Http\Controllers\API\AuthController@test');


Route::group([
    'prefix' => 'auth'

], function ($router) {
    Route::post('register', 'App\Http\Controllers\API\AccountAPIController@register');
    Route::post('authenticate', 'App\Http\Controllers\API\AuthController@login');
    Route::post('google_signin', 'App\Http\Controllers\API\AuthController@googleSignin');
    Route::post('logout', 'App\Http\Controllers\API\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\API\AuthController@refresh');
    Route::get('account', 'App\Http\Controllers\API\AccountAPIController@account');
    Route::get('test', 'App\Http\Controllers\API\AuthController@test');

});

Route::post('email/validate','App\Http\Controllers\API\AccountAPIController@validateEmail');

Route::group([
    'middleware' => 'jwt.verify'
], function ($router) {
//    CUSTOMS

    Route::get('me','App\Http\Controllers\API\AuthController@me');

    Route::get('my_stores',[StoreAPIController::class,'myStores']);


    Route::get('providers/pending-settlement', [SettlementAPIController::class, 'providersPendingSettlement']);
    Route::get('providers/{providerId}/stores/{storeId}/stats', [ProviderAPIController::class, 'stats']);

    Route::get('stores/select/{storeId}', [StoreAPIController::class,'selectStore']);
    Route::get('stores/{id}/cash_accounts', [StoreAPIController::class, 'cashAccounts']);
    Route::post('stores/upload_logo',[StoreAPIController::class,'updateLogo']);

    // Store User Management
    Route::get('stores/{id}/users', [\App\Http\Controllers\API\StoreUserAPIController::class, 'index']);
    Route::post('stores/{id}/users', [\App\Http\Controllers\API\StoreUserAPIController::class, 'store']);
    Route::put('stores/{id}/users/{userId}', [\App\Http\Controllers\API\StoreUserAPIController::class, 'update']);
    Route::delete('stores/{id}/users/{userId}', [\App\Http\Controllers\API\StoreUserAPIController::class, 'destroy']);

    Route::get('my_account','App\Http\Controllers\API\AccountAPIController@myAccount');

    Route::post('stores/balance',[MovementAPIController::class,'balance']);

    Route::get('stores/{storeId}/categories', [CategoryAPIController::class,'findByStore']);

    Route::get('stores/{storeId}/products',[ProductAPIController::class,'findByStore'] );
    Route::get('stores/{storeId}/borrowed_products', [ProductAPIController::class, 'borrowedProducts']);

    Route::get('stores/{storeId}/products/{type}', [ProductAPIController::class,'findByStore']);


    Route::get('stores/{storeId}/sale_states', [SaleStateAPIController::class,'findByStore'] );

    Route::post('products/bulk', [ProductAPIController::class, 'bulk']);
    Route::get('products/query',[ProductAPIController::class,'query'] );

    Route::post('images/upload',[ImageAPIController::class, 'uploadImage']);
    Route::post('images/product/{productId}/upload',[ImageAPIController::class, 'uploadProductImage']);
    Route::post('images/upload_general',[ImageAPIController::class, 'uploadImageGeneral']);
    Route::post('images/{id}/extract_features',[ImageAPIController::class, 'extractFeatures']);
    Route::post('images/{id}/suggest_price', [ImageAPIController::class, 'suggestPrice']); // New route
    Route::delete('images/delete/{id}',[ImageAPIController::class, 'delete']);
    Route::post('images/set_primary',[ImageAPIController::class, 'set_primary']);


    Route::get('sales/resume', [SaleAPIController::class,'countResume']);
    Route::get('sales/code/{saleId}', [SaleAPIController::class,'generateCode']);
    Route::get('sales/{saleId}/remove/{productId}',[SaleAPIController::class,'removeProduct'] );
    Route::post('sales/{saleId}/add', [SaleAPIController::class,'addProduct']);

    Route::get('sales/{saleId}/products', [ProductAPIController::class,'findForSale'] );
    Route::get('sales/{saleId}/pays', [PaymentAPIController::class,'findForSale'] );

    Route::get('sales/{saleId}/statuses', [SaleStateAPIController::class,'findSaleHistoric'] );

    // Settlement routes
    Route::get('settlements/preview', [SettlementAPIController::class, 'preview']);

    Route::put('settlements/{id}/pay', [SettlementAPIController::class, 'markAsPaid']);

//    RESOURCES
    Route::resource('movements', App\Http\Controllers\API\MovementAPIController::class);

    Route::resource('cities', App\Http\Controllers\API\CityAPIController::class);

    Route::resource('sales', App\Http\Controllers\API\SaleAPIController::class);

    Route::resource('products', App\Http\Controllers\API\ProductAPIController::class);

    Route::resource('categories', App\Http\Controllers\API\CategoryAPIController::class);

    Route::resource('sale_states', App\Http\Controllers\API\SaleStateAPIController::class);

    Route::resource('coupons', App\Http\Controllers\API\CouponAPIController::class);

    Route::resource('discounts', App\Http\Controllers\API\DiscountAPIController::class);

    Route::resource('stores', App\Http\Controllers\API\StoreAPIController::class);

    Route::resource('payment_items', App\Http\Controllers\API\PaymentItemAPIController::class);

    Route::resource('payment_states', App\Http\Controllers\API\PaymentStateAPIController::class);

    Route::resource('payment_types', App\Http\Controllers\API\PaymentTypeAPIController::class);

    Route::resource('payments', App\Http\Controllers\API\PaymentAPIController::class);

    Route::resource('bank_accounts', App\Http\Controllers\API\BankAccountAPIController::class);

    Route::resource('customers', App\Http\Controllers\API\CustomerAPIController::class);

    Route::resource('providers', App\Http\Controllers\API\ProviderAPIController::class);

    Route::resource('product_state', App\Http\Controllers\API\ProductStateAPIController::class);

    Route::resource('settlements', App\Http\Controllers\API\SettlementAPIController::class);

    Route::resource('withdrawals', App\Http\Controllers\API\WithdrawalAPIController::class);

});












