<?php

namespace App\Classes\Controller;

use app\MasterList;
use App\MasterListPriceTracking;
use Auth;
use App\Classes\Math;

class MasterListHelper 
{
    public function updatePriceTracking($masterlist, $request)
    {
        //Send current price data to price tracking before updating new data if there are any pricing changes
        if ($masterlist->price != $request->price ||
            $masterlist->ap_quantity != $request->ap_quantity ||
            $masterlist->ap_unit != $request->ap_unit ||
            $masterlist->vendor != $request->vendor
        ) {
            $pricetracking = new MasterListPriceTracking();

            $pricetracking->master_list_id = $masterlist->id;
            $pricetracking->user_id = Auth::user()->id;
            $pricetracking->price = $masterlist->price;
            $pricetracking->ap_quantity = $masterlist->ap_quantity;
            $pricetracking->ap_unit = $masterlist->ap_unit;
            $pricetracking->vendor = $masterlist->vendor;
            $pricetracking->created_at = $masterlist->updated_at;

            $pricetracking->save();
        }
    }

    public function store($masterlist, $request)
    {
        $masterlist->name = $request->input('name');
        $masterlist->price = $request->input('price');
        $masterlist->ap_quantity = $request->input('ap_quantity');
        $masterlist->ap_unit = $request->input('ap_unit');
        if ($request->yield > 1) {
            $masterlist->yield = $request->yield / 100;
        } else {
            $masterlist->yield = $request->yield;
        }
        $masterlist->ap_small_price = Math::CalcApUnitCost($request->price, $request->ap_quantity, $request->ap_unit);
        $masterlist->vendor = $request->input('vendor');
        $masterlist->category = $request->input('category');

        Auth::user()->masterlist()->save($masterlist);
    }
}