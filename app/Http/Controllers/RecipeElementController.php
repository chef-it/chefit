<?php

namespace App\Http\Controllers;

use App\Classes\Math;
use App\Classes\DesignHelper;
use App\Recipe;
use App\RecipeElement;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class RecipeElementController extends Controller
{
    /**
     * Instantiate a new MasterListController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($recipeId)
    {
        //TODO: Break out from controller.
        // Get recipe name
        $recipe = Auth::user()->recipes()->with('batchUnit')->findOrFail($recipeId);

        $recipe->menu_price = number_format($recipe->menu_price, 2);
        $recipe->data = Math::CalcRecipeData($recipe->id);
        $recipe->batch_quantity += 0;
        $recipe->portions_per_batch += 0;
        $recipe->data->portionPrice = $recipe->data->cost / $recipe->portions_per_batch;
        $recipe->instructions = htmlspecialchars($recipe->instructions);

        // Get all recipe elements for a recipe.
        $elements = Auth::user()->recipes()->find($recipeId)->elements()->with('masterlist', 'unit')->get();

        // TODO: This needs to be made DRY
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

        return view('recipes.elements.index')
            ->withElements($elements)
            ->withRecipe($recipe)
            ->withCurrencysymbol(DesignHelper::CurrencySymbol());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($recipeID)
    {
        return view('recipes.elements.create')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withIngredients(DesignHelper::IngredientsDropDown($recipeID));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreRecipeComponent $request)
    {
        $ingredientData = json_decode($request->ingredient);

        $recipeElement = new RecipeElement();
        
        $recipeElement->recipe_id = $request->recipe;
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

        return redirect()->route('recipes.elements.index', $recipeElement->recipe_id);
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('recipes.elements.index', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($recipeID, $id)
    {
        $element = Auth::user()->recipes()->findOrFail($recipeID)->elements()->findOrFail($id);
        $element->quantity = $element->quantity + 0;

        if ($element->type == 'masterlist') {
            $element->ingredientId = '{"type":"masterlist","id":"'.$element->master_list_id.'"}';
        } else if ($element->type == 'recipe') {
            $element->ingredientId = '{"type":"recipe","id":"'.$element->sub_recipe_id.'"}';
        }

        return view('recipes.elements.edit')
            ->withElement($element)
            ->withIngredients(DesignHelper::IngredientsDropDown($recipeID))
            ->withUnits(DesignHelper::UnitsDropDown());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreRecipeComponent $request, $recipe, $id)
    {
        $element = Auth::user()->recipes()->find($recipe)->elements()->findOrFail($id);

        $ingredientData = json_decode($request->ingredient);
        if ($ingredientData->type == 'masterlist') {
            $element->master_list_id = $ingredientData->id;
            $element->sub_recipe_id = null;
        } else {
            $element->master_list_id = null;
            $element->sub_recipe_id = $ingredientData->id;
        }

        $element->quantity = $request->quantity;
        $element->unit_id = $request->unit_id;

        $element->save();

        return redirect()->route('recipes.elements.index', $element->recipe_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($recipe, $id)
    {
        $element = Auth::user()->recipes()->find($recipe)->elements()->findOrFail($id);
        $element->delete();
        return redirect()->route('recipes.elements.index', $recipe);
    }
}
