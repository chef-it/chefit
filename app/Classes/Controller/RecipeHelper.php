<?php

namespace App\Classes\Controller;

use App\Classes\Math;
use App\Events\RecipeUpdated;
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
        
        $recipe->save();
        event(new RecipeUpdated($recipe));
    }

    public function updateNumbers(Recipe $recipe)
    {
        $recipe->cost = Math::CalcRecipeCost($recipe);
        $recipe->cost_percent = Math::CalcCostPercent($recipe);
        $recipe->portion_price = $recipe->cost / $recipe->portions_per_batch;

        $recipe->save();

        $this->updateSubRecipes($recipe->isSubRecipe);
    }

    public function updateSubRecipes($subRecipes)
    {
        foreach ($subRecipes as $element) {
            // Wherever the recipe is used as a sub recipe, update the element records with
            // the new price changes, and then update that recipes numbers as well
            $element->cost = Math::CalcElementCost($element);
            $element->save();
            event(new RecipeUpdated($element->recipe));
        }

    }

    public function delete(Recipe $recipe)
    {
        $this->deleteSubRecipesElementRecords($recipe->isSubRecipe);
        $recipe->delete();
    }

    public function deleteSubRecipesElementRecords($subRecipes)
    {
        foreach ($subRecipes as $element) {
            $recipe = $element->recipe;
            $element->delete();
            event(new RecipeUpdated($recipe));
        }
    }
}
