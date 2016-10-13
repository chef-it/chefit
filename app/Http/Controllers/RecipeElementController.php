<?php

namespace App\Http\Controllers;

use App\Classes\Math;
use App\Recipe;
use App\RecipeElement;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class RecipeElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($recipeId)
    {
        // Get recipe name
        $recipe = Recipe::select('name')->where('id', '=', $recipeId)->first();

        // Get all recipe elements for a recipe.
        $elements = RecipeElement::select('recipe_elements.*', 'master_list.name as master_list', 'units.name as unit')
            // Join masterlist name
            ->join('master_list', 'recipe_elements.master_list', '=', 'master_list.id')
            // Join unit name
            ->join('units', 'recipe_elements.unit', '=', 'units.id')
            ->where('recipe','=', $recipeId)
            ->get();

        foreach($elements as $element){
            $element->quantity = $element->quantity + 0;
        }

        return view('recipes.elements.index')
            ->withElements($elements)
            ->withRecipe($recipe);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.elements.create')
            ->withUnits(Math::UnitsDropDown())
            ->withIngredients(Math::IngredientsDropDown());
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
        $recipeElement->recipe = $request->recipe;
        $recipeElement->master_list = $request->master_list;
        $recipeElement->owner = Auth::user()->id;
        $recipeElement->quantity = $request->quantity;
        $recipeElement->unit = $request->unit;

        $recipeElement->save();

        return redirect()->route('recipes.elements.index', $recipeElement->recipe);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($recipe, $id)
    {
        $element = RecipeElement::find($id);
        $element->quantity = $element->quantity + 0;
        return view('recipes.elements.edit')
            ->withElement($element)
            ->withIngredients(Math::IngredientsDropDown())
            ->withUnits(Math::UnitsDropDown());
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
        $recipeElement = RecipeElement::find($id);
        $recipeElement->master_list = $request->master_list;
        $recipeElement->quantity = $request->quantity;
        $recipeElement->unit = $request->unit;

        $recipeElement->save();

        return redirect()->route('recipes.elements.index', $recipeElement->recipe);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $element = RecipeElement::find($id);
        $element->destroy($id);
        return redirect()->route('recipes.elements.index');
    }
}
