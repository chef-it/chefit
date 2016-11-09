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
        // Get recipe name
        $recipe = Auth::user()->recipes()->find($recipeId)
            ? : exit(redirect()->route('recipes.index'));

        // Get all recipe elements for a recipe.
        $elements = Auth::user()->recipes()->find($recipeId)->elements()->with('masterlist', 'unit')->get();
        $pause = true;

        foreach ($elements as $element) {
            $element->quantity = $element->quantity + 0;
            $element->cost = Math::CalcIngredientCost(
                $element->master_list_id,
                $element->quantity,
                $element->unit_id
            );

            //If the recipe cost returns -1, it means that the weight volume conversion hasn't been inputed
            //and creates a button to the page to create one.
            if ($element->cost == -1) {
                $element->cost = link_to_route('masterlist.conversions.index', 'Conversion', [$element->master_list_id], ['class' => 'btn btn-xs btn-danger btn-block']);
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
    public function create()
    {
        return view('recipes.elements.create')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withIngredients(DesignHelper::IngredientsDropDown());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate

        //Store
        $recipeElement = new RecipeElement();
        
        $recipeElement->recipe_id = $request->recipe;
        $recipeElement->master_list_id = $request->master_list_id;
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
    public function edit($recipe, $id)
    {
        $element = Auth::user()->recipes()->find($recipe)->elements()->find($id)
            ? : exit(redirect()->route('recipes.index'));
        $element->quantity = $element->quantity + 0;
        return view('recipes.elements.edit')
            ->withElement($element)
            ->withIngredients(DesignHelper::IngredientsDropDown())
            ->withUnits(DesignHelper::UnitsDropDown());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $recipe, $id)
    {
        //Validate

        //Store
        $element = Auth::user()->recipes()->find($recipe)->elements()->find($id)
            ? : exit(redirect()->route('recipes.index'));
        
        $element->master_list_id = $request->master_list_id;
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
        $element = Auth::user()->recipes()->find($recipe)->elements()->find($id)
            ? : exit(redirect()->route('recipes.index'));
        $element->delete();
        return redirect()->route('recipes.elements.index', $recipe);
    }
}
