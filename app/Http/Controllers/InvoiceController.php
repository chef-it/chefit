<?php

namespace App\Http\Controllers;

use App\Classes\DesignHelper;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class InvoiceController extends Controller
{
    /**
     * Instantiate a new InvoiceController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Auth::user()->invoices;
        return view('invoices.index')
            ->withInvoices($invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withVendors(DesignHelper::VendorsDropDown());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = new Invoice();

        $invoice->date = $request->date;
        $invoice->vendor = $request->vendor;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->user_id = Auth::user()->id;
        $invoice->grand_total = 0;

        $invoice->save();

        return redirect()->route('invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Auth::user()->invoices()->find($id);
        return view('invoices.edit')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withVendors(DesignHelper::VendorsDropDown())
            ->withInvoice($invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = Auth::user()->invoices()->find($id);

        $invoice->date = $request->date;
        $invoice->vendor = $request->vendor;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->user_id = Auth::user()->id;
        $invoice->grand_total = 0;

        $invoice->save();

        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
