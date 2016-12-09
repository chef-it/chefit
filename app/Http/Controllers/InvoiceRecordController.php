<?php

namespace App\Http\Controllers;

use App\Classes\Controller\InvoiceRecordHelper;
use App\Classes\DesignHelper;
use App\Http\Requests\StoreInvoiceRecord;
use App\Invoice;
use App\InvoiceRecord;
use Illuminate\Http\Request;
use Auth;

class InvoiceRecordController extends Controller
{
    protected $helper;

    public function __construct(InvoiceRecordHelper $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Invoice $invoice)
    {
        $this->authorize('invoice', $invoice);
        return view('invoices.records.index')
            ->withInvoice($invoice)
            ->withCurrencysymbol(DesignHelper::CurrencySymbol())
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withCategories(DesignHelper::MasterListCategoriesDropDown())
            ->withMasterlist(DesignHelper::IngredientsDropDown(null,false));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('invoices.records.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRecord $request, Invoice $invoice, InvoiceRecord $record)
    {
        $this->authorize('invoice', $invoice);
        $this->helper->store($invoice, $request, $record);

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
        return redirect()->route('invoices.records.index', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('invoices.records.index', $id);
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
        return redirect()->route('invoices.records.index', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice, InvoiceRecord $record)
    {
        $invoice->grand_total = $invoice->grand_total - $record->price;
        $invoice->save();
        $record->delete();

        return redirect()->route('invoices.records.index', $invoice->id);
    }
}
