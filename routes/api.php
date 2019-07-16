<?php

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Product;
use App\SaleItem;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/reports/{fdate}/{fmonth}/', function($fdate, $fmonth) {
//    return SaleItem::whereDate('created_at', '>', "$fdate-$fmonth-31")->get();
//});

Route::get('/reports/{fdate}/{fmonth}/{tdate}/{tmonth}', function($fdate, $fmonth, $tdate, $tmonth) {
    return SaleItem::whereDate('created_at', '>=', "$fdate-$fmonth-01")->whereDate('created_at', '<=', "$tdate-$tmonth-31")->get()->groupBy('product.name');
});

Route::get('/product', function () {
    return new ProductResource(Product::all());
});