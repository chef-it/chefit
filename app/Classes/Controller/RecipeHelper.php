<?php

namespace App\Classes\Controller;

use App\Classes\Math;
use app\Recipe;
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
        
        $recipe->cost = Math::CalcRecipeCost($recipe);
        $recipe->cost_percent = Math::CalcCostPercent($recipe);
        $recipe->portion_price = $recipe->cost / $recipe->portions_per_batch;

        $recipe->save();
    }

    public function updateNumbers(Recipe $recipe)
    {
        $recipe->cost = Math::CalcRecipeCost($recipe);
        $recipe->cost_percent = Math::CalcCostPercent($recipe);
        $recipe->portion_price = $recipe->cost / $recipe->portions_per_batch;

        $recipe->save();

        $pause = 1;

        if (count($recipe->isSubRecipe)) {
            foreach ($recipe->isSubRecipe as $element) {
                // Wherever the recipe is used as a sub recipe, update the element records with
                // the new price changes, and then update the recipe numbers as well
                $element->cost = Math::CalcElementCost($element);
                $element->save();
                $this->updateNumbers($element->recipe);
            }
        }

    }
}