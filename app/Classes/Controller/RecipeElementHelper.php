<?php

namespace App\Classes\Controller;

use app\Recipe;
use app\RecipeElement;
use Auth;
use App\Classes\Math;

class RecipeElementHelper 
{

    protected $recipeHelper;

    public function __construct(RecipeHelper $recipeHelper)
    {
        $this->recipeHelper = $recipeHelper;
    }
    
    public function store(Recipe $recipe, RecipeElement $recipeElement, $request)
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
        $recipeElement->cost = Math::CalcElementCost($recipeElement);

        $recipeElement->save();

        $this->recipeHelper->updateNumbers($recipe);
    }

    public function delete(Recipe $recipe, RecipeElement $element)
    {
        $element->delete();

        $this->recipeHelper->updateNumbers($recipe);
    }

    public function prepareRecipeForIndex(Recipe $recipe)
    {
        $recipe->load('batchUnit');
        $recipe->instructions = htmlspecialchars($recipe->instructions);
        
        return $recipe;
    }

    public function prepareElementsForIndex(Recipe $recipe)
    {
        // Get all recipe elements for a recipe.
        $elements = $recipe->elements()->with('masterlist', 'unit')->get();
        
        return $elements;
    }
}