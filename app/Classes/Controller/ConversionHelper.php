<?php

namespace App\Classes\Controller;

use App\MasterListPriceTracking;
use Auth;
use App\Classes\Math;

class ConversionHelper
{
    public function store($conversion, $request, $masterlist)
    {
        $conversion->left_quantity = $request->left_quantity;
        $conversion->left_unit = $request->left_unit;
        $conversion->right_quantity = $request->right_quantity;
        $conversion->right_unit = $request->right_unit;
        $conversion->user_id = Auth::user()->id;

        Auth::user()->masterlist->find($masterlist)->conversion()->save($conversion);
    }
}