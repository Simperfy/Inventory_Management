<?php

namespace App\Http\Controllers;

use App\CurrentStock;
use App\Product;
use App\Sale;
use App\SaleItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutOfStockException extends \Exception {};

class SalesController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $sale = Sale::create([
                    'amount'      => $request->amount,
                    'amount_paid' => $request->amount_paid,
                    'change'      => ($request->amount_paid - $request->amount),
                    'user_id'     => auth()->id(),
                                                                         ]);


                foreach ($request->cart as $cart) {
                    $product = Product::where('barcode', $cart['barcode'])->first();
                    SaleItem::create([
                        'quantity_sold'  => $cart['quantity'],
                        'price_per_unit' => $cart['price'],
                        'price'          => ($cart['price'] * $cart['quantity']),
                        'sale_id'        => $sale->id,
                        'user_id'        => auth()->id(),
                        'product_id'     => $product->id,
                    ]);

                    $cs = $product->currentStock;
                    if ($cs->remaining -= $cart['quantity'] < 0) {
                        throw new OutOfStockException();
                    }
                    $cs->save();
                }

            }, 5);
        } catch (OutOfStockException $e) {
            return redirect()->back()->with(['message' => "Item Out Of Stock", 'alert-type' => 'error']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'alert-type' => 'error']);
        }

        return redirect(route('voyager.sales.index'))->with(['message' => "Successfully Added New Sales Record", 'alert-type' => 'success']);
    }

    public function destroy(Sale $sale)
    {
        $sale->saleItems()->delete();
        $sale->delete();
        return redirect()->back()->with(['message' => "Successfully Deleted Sales Record", 'alert-type' => 'success']);
    }
}
