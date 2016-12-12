<?php

namespace App\Classes\Controller;

use app\Recipe;
use app\RecipeElement;
use Auth;
use App\Classes\Math;

class RecipeElementHelper 
{

    public function store(RecipeElement $recipeElement, $request)
    {
        $ingredientData = json_decode($request->ingredient);


        //Hack until I figure out why on store $request->recipe
        //is an instance of App\Recipe, but on update it is just the ID
        if ($request->recipe instanceof Recipe) {
            $recipeElement->recipe_id = $request->recipe->id;
        } else {
            $recipeElement->recipe_id = $request->recipe;
        }

        $recipeElement->type = $ingredientData->type;
        if ($ingredientData->type == 'masterlist') {
            $recipeElement->master_list_id = $ingredientData->id;
            $recipeElement->sub_recipe_id = null;
        } else if ($ingredientData->type == 'recipe') {
            $recipeElement->master_list_id = null;
            $recipeElement->sub_recipe_id = $ingredientData->id;
        }
        $recipeElement->user_id = Auth::user()->id;
        $recipeElement->quantity = $request->quantity;
        $recipeElement->unit_id = $request->unit_id;

        $recipeElement->save();
    }

    public function prepareRecipeForIndex($recipe)
    {
        $recipe->load('batchUnit');
        $recipe->instructions = htmlspecialchars($recipe->instructions);
        
        return $recipe;
    }

    public function prepareElementsForIndex($recipe)
    {
        // Get all recipe elements for a recipe.
        $elements = $recipe->elements()->with('masterlist', 'unit')->get();

        
        foreach ($elements as $element) {
            $element->quantity = $element->quantity + 0;
            if ($element->type == 'masterlist') {
                $element->cost = Math::CalcIngredientCost(
                    $element->master_list_id,
                    $element->quantity,
                    $element->unit_id
                );
            } else if ($element->type == 'recipe') {
                $element->cost = Math::CalcSubRecipeCost(
                    $element->sub_recipe_id,
                    $element->quantity,
                    $element->unit_id
                );
            }


            //If the recipe cost returns -1, it means that the weight volume conversion hasn't been inputed
            //and creates a button to the page to create one.
            if ($element->type == 'masterlist' && $element->cost == -1) {
                $element->cost = link_to_route('masterlist.conversions.index', 'Conversion', [$element->master_list_id], ['class' => 'btn btn-xs btn-danger btn-block']);
            } else if ($element->type == 'recipe' && $element->cost == -1) {
                $element->cost = 'I didn\'t account for this calculation. Please let me know I need to add it';
            } else {
                $element->cost = number_format($element->cost, 2);
            }
        }
        
        return $elements;
    }
}