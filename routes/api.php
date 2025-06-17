<?php

use App\Http\Controllers\API\MovementAPIController;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\SaleAPIController;
use App\Http\Controllers\API\SaleStateAPIController;
use App\Http\Controllers\API\StoreAPIController;
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

    Route::get('stores/select/{storeId}', [StoreAPIController::class,'selectStore']);
    Route::post('stores/upload_logo',[StoreAPIController::class,'updateLogo']);

    Route::get('my_account','App\Http\Controllers\API\AccountAPIController@myAccount');

    Route::post('accounts/balance',[MovementAPIController::class,'balance']);

    Route::get('store/{storeId}/categories',
        'App\Http\Controllers\API\CategoryAPIController@findByStore');

    Route::get('store/{storeId}/products',
        'App\Http\Controllers\API\ProductAPIController@findByStore');

    Route::get('store/{storeId}/products/{type}',
        'App\Http\Controllers\API\ProductAPIController@findByStore');


    Route::get('stores/{storeId}/sale_states', [SaleStateAPIController::class,'findByStore'] );


    Route::post('images/upload','App\Http\Controllers\API\ImageAPIController@uploadImage');
    Route::delete('images/delete/{id}','App\Http\Controllers\API\ImageAPIController@delete');
    Route::put('images/set_primary','App\Http\Controllers\API\ImageAPIController@set_primary');


    Route::get('sales/resume', [SaleAPIController::class,'countResume']);
    Route::get('sales/code/{saleId}', [SaleAPIController::class,'generateCode']);

    Route::get('sales/{saleId}/products', [ProductAPIController::class,'findForSale'] );

    Route::get('sales/{saleId}/statuses', [SaleStateAPIController::class,'findSaleHistoric'] );

    Route::get('sale_states/historic/{saleId}',[SaleStateAPIController::class,'findSaleHistoric'] );


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

});












