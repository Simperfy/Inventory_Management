<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class BarcodeController extends Controller
{
    public function create()
    {
        return view('barcodes');
    }

    // @todo validate if $request->itemQuantity is a number
    public function print(Request $request)
    {
//        return view('barcodes-print', ['itemBarcodes' => $request->itemBarcodes, 'itemQuantity' => $request->itemQuantity]);
        if (!$request->itemBarcodes || !$request->itemQuantity)
            return redirect()->back()->with(['message' => 'Please Add Items First', 'alert-type' => 'error']);

        if ( count($request->itemBarcodes) !== count($request->itemQuantity) )
            return redirect()->back()->with(['message' => 'Items Indexes Doesn\'t match', 'alert-type' => 'error']);

        return PDF::loadView('barcodes-print',
            ['itemBarcodes' => $request->itemBarcodes, 'itemQuantity' => $request->itemQuantity]
        )->stream('test-file.pdf');
    }
}
