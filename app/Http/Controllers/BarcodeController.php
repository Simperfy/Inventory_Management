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

    public function print(Request $request)
    {
        return PDF::loadView('barcodes-print')->stream('test-file.pdf');
    }
}
