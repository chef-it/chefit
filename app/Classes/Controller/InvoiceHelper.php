<?php

namespace App\Classes\Controller;

use App\MasterListPriceTracking;
use Auth;
use App\Classes\Math;

class InvoiceHelper 
{

    public function store($invoice, $request)
    {
        $invoice->date = $request->date;
        $invoice->vendor = $request->vendor;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->grand_total = 0;
        
        Auth::user()->invoices()->save($invoice);
    }
}