<?php

namespace App\Http\Controllers;

use App\Classes\Controller\RecipeHelper;
use App\Recipe;
use Illuminate\Http\Request;
use App\Classes\Math;
use App\Classes\DesignHelper;
use Auth;

use App\Http\Requests;

class RecipeController extends Controller
{
    protected $helper;
    
    /**
     * Instantiate a new RecipeController instance.
     */
    public function __construct(RecipeHelper $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Auth::user()->recipes;

        return view('recipes.index')
            ->withRecipes($recipes)
            ->withCurrencysymbol(DesignHelper::CurrencySymbol());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withOptions(DesignHelper::RecipeOptionsDropDown())
            ->withCurrencysymbol(DesignHelper::CurrencySymbol());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreRecipe $request, Recipe $recipe)
    {
        $this->helper->store($recipe, $request);

        return redirect()->route('recipes.elements.index', $recipe->id);
    }

    /**
     * Not used, redirect to index.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('recipes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        $this->authorize('recipe', $recipe);
        return view('recipes.edit')
            ->withRecipe($recipe)
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withOptions(DesignHelper::RecipeOptionsDropDown())
            ->withCurrencysymbol(DesignHelper::CurrencySymbol());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreRecipe $request, Recipe $recipe)
    {
        $this->authorize('recipe', $recipe);
        $this->helper->store($recipe, $request);

        return redirect()->route('recipes.index');
    }
    
    public function instructions(Request $request, Recipe $recipe){
        $this->authorize('recipe', $recipe);
        $recipe->instructions = $request->instructions;
        $recipe->save();

        return redirect()->route('recipes.elements.index', $recipe->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        $this->authorize('recipe', $recipe);
        $this->helper->delete($recipe);
        return redirect()->route('recipes.index');
    }
}
