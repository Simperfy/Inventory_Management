<?php

namespace App\Http\Controllers;

use App\CurrentStock;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Whatever is in Product must be in Current Stock
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $product = Product::create([
                    'name' => $request->name,
                    'barcode' => $request->barcode,
                    'price' => $request->price
                ]);
                CurrentStock::create([
                    'remaining' => 0,
                    'product_id' => $product->id
                ]);

            }, 5);
        } catch (\Exception $e) {
        return redirect()->back()->with(['message' => $e->getMessage(), 'alert-type' => 'error']);
        }
        return redirect()->back()->with(['message' => "Successfully Added Product", 'alert-type' => 'success']);
    }

    public function destroy(Product $product) {

        try {
            DB::transaction(function () use ($product) {
                foreach($product->stocks as $stock) { // delete all individual stock
                    $stock->delete();
                }

                $product->currentStock->delete(); // delete total stock
                $product->delete(); // delete product

                // @todo add ability to delete sales items
                // @todo consider NOT ADDING FEATURE TO DELETE A PRODUCT AS IT WILL BE CHAOTIC TO THE INVETONRY SYSTEM
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'alert-type' => 'error']);
        }

        return redirect()->back()->with(['message' => "Successfully Deleted Product w/ stocks Record", 'alert-type' => 'success']);
    }
}
