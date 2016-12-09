<?php

namespace App\Http\Controllers;

use App\Classes\Controller\InvoiceHelper;
use App\Classes\DesignHelper;
use App\Http\Requests\StoreInvoice;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class InvoiceController extends Controller
{

    protected $helper;

    /**
     * Instantiate a new InvoiceController instance.
     */
    public function __construct(InvoiceHelper $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
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
    public function store(StoreInvoice $request, Invoice $invoice)
    {
        $this->helper->store($invoice, $request);

        return redirect()->route('invoices.records.index', $invoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('invoices.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $this->authorize('invoice', $invoice);
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
    public function update(StoreInvoice $request, Invoice $invoice)
    {
        $this->authorize('invoice', $invoice);
        $this->helper->store($invoice, $request);

        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $this->authorize('invoice', $invoice);
        $invoice->delete();
        return redirect()->route('invoice.index');
    }
}
