<?php

namespace App\Http\Controllers;

use App\CurrentStock;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    // Whatever added in stock must be added in Current Stock
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Stock::create([
                    'quantity' => $request->quantity,
                    'product_id' => $request->product_id,
                    'supplier_id' => $request->supplier_id,
                    'purchase_price' => $request->purchase_price,
                ]);

                $cs = CurrentStock::where('product_id', $request->product_id)->first();
                $cs->remaining += $request->quantity;
                $cs->save();

            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'alert-type' => 'error']);
        }
        return redirect()->back()->with(['message' => "Successfully Added Stocks", 'alert-type' => 'success']);
    }
}
