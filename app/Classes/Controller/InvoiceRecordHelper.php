<?php

namespace App\Classes\Controller;

use App\MasterListPriceTracking;
use Auth;
use App\Classes\Math;
use App\MasterList;
use Carbon\Carbon;

class InvoiceRecordHelper 
{

    public function store($invoice, $request, $record)
    {
        $masterlistData = json_decode($request->masterlist);

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
        $record->invoice_id = $invoice->id;
        $record->user_id = Auth::user()->id;
        $record->category = $request->category;
        $record->save();
        
        $invoice->grand_total += $record->price;
        $invoice->save();
    }
}