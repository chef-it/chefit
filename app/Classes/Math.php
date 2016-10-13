<?php

namespace App\Classes;
use App\MasterList;
use App\Recipe;
use App\RecipeElement;
use Illuminate\Support\Facades\DB;
use App\Units;
use Auth;

/**
 * Class Math
 * @package App\Classes
 */
class Math {

    /**
     * Returns the price per Small Unit for a master_list entry.
     *
     * @param $price
     * @param $ap_quantity
     * @param $ap_unit
     * @return float
     */
    public static function CalcApUnitCost($price,$ap_quantity,$ap_unit){
        $units = DB::table('units')->select('factor')->where('id', '=', $ap_unit)->first();
        return ($price / $ap_quantity) / $units->factor;
    }

    /**
     * Returns the ingredient cost.
     *
     * @param $master_list
     * @param $quantity
     * @param $unit
     * @return mixed
     */
    public static function CalcIngredientCost($master_list, $quantity, $unit){
        // Get master_list record
        $ingredient = MasterList::find($master_list);
        // Get units record for master_list small unit
        $fromUnit = Units::find(Math::GetApSmallUnit($ingredient->ap_unit));
        // Get units record for $unit
        $toUnit = Units::find($unit);

        // If from and to are the same, the ingredient is at the small price already, just multiply
        // by quantity and return.
        if($fromUnit->id == $toUnit->id){
            return $ingredient->ap_small_price * $quantity;
        }

        // If from and to are in the same system, and same type, apply factor and return.
        if($fromUnit->system == $toUnit->system && $fromUnit->weight == $toUnit->weight){
            return $ingredient->ap_small_price * $toUnit->factor * $quantity;
        }else {
            die(dump($ingredient, $fromUnit, $toUnit, $quantity));
        }
    }

    public static function CalcRecipeCost($recipe){
        $elements = RecipeElement::where('recipe', '=', $recipe)->get();
        $recipe = new \stdClass();
        $recipe->cost = 0;

        // Cycle through each ingredient, calculate cost, and add to the total cost;
        foreach ($elements as $element){
            $recipe->cost += Math::CalcIngredientCost(
                $element->master_list,
                $element->quantity,
                $element->unit
            );
        }
        return $recipe->cost;
    }

    public static function CalcRecipeCostPercent($recipeID){
        $recipe = Recipe::find($recipeID);
        $recipe->cost = Math::CalcRecipeCost($recipeID);

        // Divide total cost by menu price and return percentage.
        return number_format(($recipe->cost / $recipe->menu_price * 100),2);
    }

    /**
     * Determines the Small Unit for a master_list entry based on type and system.
     *
     * @param $ap_unit
     * @return int|null
     */
    public static function GetApSmallUnit($ap_unit){
        $units = DB::table('units')->select('system','weight')->where('id', '=', $ap_unit)->first();
        switch(TRUE) {
            //US System, Volume, Return 'fl oz'
            case ($units->system == 1 && $units->weight == 0):
                $SmallUnit = 2;
                break;
            //US System, Weight, Return 'oz'
            case ($units->system == 1 && $units->weight == 1):
                $SmallUnit = 1;
                break;
            //Metric System, Volume, Return 'mL'
            case ($units->system == 3 && $units->weight == 0):
                $SmallUnit = 4;
                break;
            //Metric System, Weight, Return 'gram'
            case ($units->system == 3 && $units->weight == 1):
                $SmallUnit = 3;
                break;
            //General, Return NULL
            default:
                $SmallUnit = $ap_unit;
                break;
        }
        return $SmallUnit;
    }
}