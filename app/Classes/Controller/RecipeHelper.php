<?php

namespace App\Classes\Controller;

use Auth;

class RecipeHelper 
{

    public function store($recipe, $request)
    {
        $recipe->name = $request->name;

        if ($request->menu_price == '') {
            $recipe->menu_price = null;
        } else {
            $recipe->menu_price = $request->menu_price;
        }

        $recipe->portions_per_batch = $request->portions_per_batch;
        $recipe->batch_quantity = $request->batch_quantity;
        $recipe->batch_unit = $request->batch_unit;
        if ($request->component_only == null) {
            $recipe->component_only = 0;
        } else {
            $recipe->component_only = $request->component_only;
        }
        $recipe->user_id = Auth::user()->id;

        $recipe->save();
    }
}