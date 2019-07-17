<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('voyager.login'));
});

//Route::post('/admin/sales/store', 'SalesController@store')->name('sales.store');
Route::get('/dump', function(\Illuminate\Http\Request $request) {
    return $request->all();
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/report', function () {
        return view('charts');
    })->name('admin.report');

    Route::get('/print/barcode', function () {
        return view('barcode');
    })->name('admin.barcode');

    Route::post('stocks', ['uses' => 'StockController@store', 'as' => 'voyager.stocks.store']);
    Route::post('products', ['uses' => 'ProductController@store', 'as' => 'voyager.products.store']);
    Route::post('sales', 'SalesController@store')->name('voyager.sales.store');
    Route::delete('sales/{sale}', ['uses' => 'SalesController@destroy', 'as' => 'voyager.sales.destroy']);
});
