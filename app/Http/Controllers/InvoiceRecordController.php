<?php

namespace App\Http\Controllers;

use App\Classes\DesignHelper;
use App\Http\Requests\StoreInvoiceRecord;
use App\InvoiceRecord;
use App\MasterListPriceTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\MasterList;
use App\Classes\Math;
use Auth;

class InvoiceRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($invoice)
    {
        $invoice = Auth::user()->invoices()->find($invoice);
        $pause = 1;
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
    public function store(StoreInvoiceRecord $request, $invoiceId)
    {
        $invoice = Auth::user()->invoices()->find($invoiceId);
        $masterlistData = json_decode($request->masterlist);
        $record = new InvoiceRecord();

        //Check to see if new master_master list entry or existing
        if (!$masterlistData) {
            //New master_list entry
            $masterlist = new MasterList();
            
            $masterlist->name = $request->masterlist;
            $masterlist->price = $request->price;
            $masterlist->ap_quantity = $request->ap_quantity;
            $masterlist->ap_unit = $request->ap_unit;
            $masterlist->yield = 1;
            $masterlist->ap_small_price = Math::CalcApUnitCost($request->price, $request->ap_quantity, $request->ap_unit);
            $masterlist->user_id = Auth::user()->id;
            $masterlist->vendor = $invoice->vendor;
            $masterlist->category = $request->category;

            $masterlist->save();

            $record->master_list_id = $masterlist->id;
        } else {
            //Existing master_list entry
            $masterlist = Auth::user()->masterlist()->find($masterlistData->id);
            $date = new Carbon($invoice->date);

            if ($date > $masterlist->updated_at){
                //invoice is newer than current master_list entry

                //send current information to price_tracking
                $pricetracking = new MasterListPriceTracking();
                $pricetracking->master_list_id = $masterlist->id;
                $pricetracking->user_id = Auth::user()->id;
                $pricetracking->price = $masterlist->price;
                $pricetracking->ap_quantity = $masterlist->ap_quantity;
                $pricetracking->ap_unit = $masterlist->ap_unit;
                $pricetracking->vendor = $masterlist->vendor;
                $pricetracking->created_at = $masterlist->updated_at;
                $pricetracking->save();

                //update master_list entry to invoice data
                $masterlist->price = $request->price;
                $masterlist->ap_quantity = $request->ap_quantity;
                $masterlist->ap_unit = $request->ap_unit;
                $masterlist->ap_small_price = Math::CalcApUnitCost($request->price, $request->ap_quantity, $request->ap_unit);
                $masterlist->vendor = $invoice->vendor;
                $masterlist->category = $request->category;

                $masterlist->save();
            } else {
                //invoice is older than current entry, add price tracking information
                $pricetracking = new MasterListPriceTracking();
                $pricetracking->master_list_id = $masterlist->id;
                $pricetracking->user_id = Auth::user()->id;
                $pricetracking->price = $request->price;
                $pricetracking->ap_quantity = $request->ap_quantity;
                $pricetracking->ap_unit = $request->ap_unit;
                $pricetracking->vendor = $invoice->vendor;
                $pricetracking->save();
            }
            $record->master_list_id = $masterlistData->id;
        }

        $record->price = $request->price;
        $record->ap_quantity = $request->ap_quantity;
        $record->ap_unit = $request->ap_unit;
        $record->invoice_id = $invoiceId;
        $record->user_id = Auth::user()->id;
        $record->category = $request->category;
        $record->save();

        $invoice = Auth::user()->invoices()->find($invoiceId);
        $invoice->grand_total += $record->price;
        $invoice->save();

        return redirect()->route('invoices.records.index', $invoiceId);
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
    public function destroy($invoiceId, $recordId)
    {
        $invoice = Auth::user()->invoices()->find($invoiceId);
        $record = $invoice->records()->find($recordId);

        $invoice->grand_total = $invoice->grand_total - $record->price;
        $invoice->save();
        $record->delete();

        return redirect()->route('invoices.records.index', $invoiceId);
    }
}
