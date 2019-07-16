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

use Carbon\Carbon;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// @todo old delete anytime
//Route::get('/reports/{fdate}/{fmonth}/{tdate}/{tmonth}', function($fdate, $fmonth, $tdate, $tmonth) {
//    return SaleItem::whereDate('created_at', '>=', "$fdate-$fmonth-01")->whereDate('created_at', '<=', "$tdate-$tmonth-31")->get()->groupBy('product.name');
//});

Route::get('/reports', function(Request $request) {
    $dateFrom = $request->get('dateFrom');
    $dateTo = $request->get('dateTo');
    $dateFrom = Carbon::parse($dateFrom)->format('Y-m-d');
    $dateTo = Carbon::parse($dateTo)->format('Y-m-d');

    return SaleItem::whereDate('created_at', '>=', $dateFrom)->whereDate('created_at', '<=', $dateTo)->get()->groupBy('product.name');
});

Route::get('/product', function () {
    return new ProductResource(Product::all());
});