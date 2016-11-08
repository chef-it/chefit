<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\RecipeElement;
use Illuminate\Http\Request;
use App\Classes\Math;
use App\Classes\DesignHelper;
use Auth;

use App\Http\Requests;

class RecipeController extends Controller
{
    /**
     * Instantiate a new RecipeController instance.
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
    public function index()
    {
        $recipes = Auth::user()->recipes;

        foreach ($recipes as $recipe) {
            $recipe->costPercent = Math::CalcRecipeCostPercent($recipe->id);
            $recipe->menu_price = number_format($recipe->menu_price, 2);
        }

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
    public function store(Request $request)
    {
        // Validate

        // Store
        $recipe = new Recipe();

        $recipe->name = $request->name;
        $recipe->menu_price = $request->menu_price;
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

        return redirect()->route('recipes.index');
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
    public function edit($id)
    {
        $recipe = $recipes = Auth::user()->recipes()->find($id)
            ? : exit(redirect()->route('recipes.index'));
        $recipe->portions_per_batch = $recipe->portions_per_batch + 0;
        $recipe->batch_quantity = $recipe->batch_quantity + 0;
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
    public function update(Request $request, $id)
    {
        // Validate

        // Store
        $recipe = $recipes = Auth::user()->recipes()->find($id)
            ? : exit(redirect()->route('recipes.index'));

        $recipe->name = $request->name;
        $recipe->menu_price = $request->menu_price;
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

        return redirect()->route('recipes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = $recipes = Auth::user()->recipes()->find($id)
            ? : exit(redirect()->route('recipes.index'));
        $recipe->delete();
        return redirect()->route('recipes.index');
    }
}
