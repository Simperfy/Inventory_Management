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

// For Dumping requests
/*Route::get('/dump', function(\Illuminate\Http\Request $request) {
    return $request->all();
});*/

/*Route::get('/barcodes/print', function() {
//    return view('barcodes-print');
    return PDF::loadView('barcodes-print')->stream('test-file.pdf');
});*/

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/report', function () {
        return view('charts');
    })->name('admin.report');

    Route::get('/barcodes', 'BarcodeController@create')->name('admin.barcodes');

//    Route::get('/barcodes/print', 'BarcodeController@print'); safe to delete
    Route::post('/barcodes/print', 'BarcodeController@print');

    Route::post('stocks', ['uses' => 'StockController@store', 'as' => 'voyager.stocks.store']);
    Route::post('products', ['uses' => 'ProductController@store', 'as' => 'voyager.products.store']);
    Route::delete('products/{product}', ['uses' => 'ProductController@destroy', 'as' => 'voyager.products.destroy']);

    Route::post('sales', 'SalesController@store')->name('voyager.sales.store');
    Route::delete('sales/{sale}', ['uses' => 'SalesController@destroy', 'as' => 'voyager.sales.destroy']);
});
