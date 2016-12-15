<?php

namespace App\Http\Controllers;

use App\Classes\Controller\RecipeElementHelper;
use App\Classes\DesignHelper;
use App\Recipe;
use App\RecipeElement;
use Auth;

use App\Http\Requests;

class RecipeElementController extends Controller
{
    protected $helper;

    /**
     * Instantiate a new MasterListController instance.
     */
    public function __construct(RecipeElementHelper $helper)
    {
        $this->middleware('auth');
        $this->helper = $helper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Recipe $recipe)
    {
        $recipe = $this->helper->prepareRecipeForIndex($recipe);
        $elements = $this->helper->prepareElementsForIndex($recipe);

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
    public function create(Recipe $recipe)
    {
        return view('recipes.elements.create')
            ->withUnits(DesignHelper::UnitsDropDown())
            ->withIngredients(DesignHelper::IngredientsDropDown($recipe->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreRecipeComponent $request, Recipe $recipe, RecipeElement $element)
    {
        $this->authorize('recipe', $recipe);
        $this->helper->store($recipe, $element, $request);

        return redirect()->route('recipes.elements.index', $element->recipe_id);
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
    public function edit(Recipe $recipe, RecipeElement $element)
    {
        $this->authorize('element', [$element, $recipe]);

        //Haven't decided if this should refactor to helper.
        if ($element->type == 'masterlist') {
            $element->ingredientId = '{"type":"masterlist","id":"'.$element->master_list_id.'"}';
        } else if ($element->type == 'recipe') {
            $element->ingredientId = '{"type":"recipe","id":"'.$element->sub_recipe_id.'"}';
        }

        return view('recipes.elements.edit')
            ->withElement($element)
            ->withIngredients(DesignHelper::IngredientsDropDown($recipe->id))
            ->withUnits(DesignHelper::UnitsDropDown());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreRecipeComponent $request, Recipe $recipe, RecipeElement $element)
    {
        $this->authorize('element', [$element, $recipe]);
        $this->helper->store($recipe, $element, $request);

        return redirect()->route('recipes.elements.index', $element->recipe_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe, RecipeElement $element)
    {
        $this->authorize('element', [$element, $recipe]);
        $this->helper->delete($recipe, $element);
        return redirect()->route('recipes.elements.index', $recipe->id);
    }
}
