<?php
namespace App\Classes;

use App\Conversion;
use App\MasterList;
use App\Recipe;
use App\RecipeElement;
use Illuminate\Support\Facades\DB;
use App\Unit;
use Auth;

/**
 * Class Math
 * @package App\Classes
 */
class Math
{

    /**
     * Returns the price per Small Unit for a master_list entry.
     *
     * @param $price
     * @param $ap_quantity
     * @param $ap_unit
     * @return float
     */
    public static function CalcApUnitCost($price, $ap_quantity, $ap_unit)
    {
        $units = DB::table('units')->select('factor')->where('id', '=', $ap_unit)->first();
        return ($price / $ap_quantity) / $units->factor;
    }

    /**
     * Returns the ingredient cost. Input is the master_list details, Output is requested details.
     *
     * @param $master_list
     * @param $quantity
     * @param $unit
     * @return mixed
     */
    public static function CalcIngredientCost($master_list, $quantity, $unit)
    {
        // Get master_list record
        $ingredient = MasterList::find($master_list);
        // Get units record for master_list small unit
        $inputUnit = Unit::find(Math::GetApSmallUnit($ingredient->ap_unit));
        // Get units record for $unit
        $outputUnit = Unit::find($unit);

        // If a weight-volume conversion is required
        if ($inputUnit->weight != $outputUnit->weight) {
            // Get conversion from database with measurement unit details included.
            $conversion = Conversion::with('leftUnit', 'rightUnit')
                ->where('master_list_id', '=', $master_list)
                ->first();
            if (count($conversion)) {
                $conversionFactor = $conversion->right_quantity / $conversion->left_quantity;
                // Calculate Conversion
                if ($inputUnit->system == $conversion->leftUnit->system && $inputUnit->weight == $conversion->leftUnit->weight) {
                    $ingredient->ap_small_price /= $conversionFactor * $conversion->rightUnit->factor;
                    $inputUnit = $conversion->rightUnit;
                } elseif ($inputUnit->system == $conversion->rightUnit->system && $inputUnit->weight == $conversion->rightUnit->weight) {
                    $ingredient->ap_small_price *= $conversionFactor / $conversion->leftUnit->factor;
                    $inputUnit = $conversion->leftUnit;
                } else {
                    // Return -1 to trigger button on recipes.elements.index letting the user know the conversion
                    // set up doesn't account for measurements entered into to recipe ingredient.
                    return -1;
                }
                $pause = 2;
            } else {
                // Return -1 to trigger button on recipes.elements.index letting the user know there isn't a conversion
                // set up.
                return -1;
            }
        }

        // If input and output are different systems, but same type, convert input to output system,
        // modify the ingredient price to reflect new change, and continue on.
        if ($inputUnit->system != $outputUnit->system && $inputUnit->weight == $outputUnit->weight) {
            if ($inputUnit->weight == 1) {
                // We're dealing with weight
                if ($outputUnit->system == 1) {
                    // Input needs converted from grams to oz
                    $ingredient->ap_small_price /= 0.0352739619;
                    $inputUnit->system = 1;
                    $inputUnit->id = 1;
                    $inputUnit->name = 'oz';
                } else {
                    // Input needs converted from oz to gram
                    $ingredient->ap_small_price *= 0.0352739619;
                    $inputUnit->system = 3;
                    $inputUnit->id = 3;
                    $inputUnit->name = 'gram';
                }
            } else {
                // We're dealing with volume
                if ($outputUnit->system == 1) {
                    // Input needs converted from mL to fl-oz
                    $ingredient->ap_small_price /= 0.033814;
                    $inputUnit->system = 1;
                    $inputUnit->id = 2;
                    $inputUnit->name = 'fl oz';
                } else {
                    // Input needs converted from fl-oz to mL
                    $ingredient->ap_small_price *= 0.033814;
                    $inputUnit->system = 3;
                    $inputUnit->id = 4;
                    $inputUnit->name = 'ml';
                }
            }
        }

        // If input and output are in the same measurement system, and the same type, apply factor and
        // return. Previous functions should have converted everything already, the if statement is a
        // double check.  TODO: change dump to error after weight <-> volume implemented.
        if ($inputUnit->system == $outputUnit->system && $inputUnit->weight == $outputUnit->weight) {
            return $ingredient->ap_small_price * $outputUnit->factor * $ingredient->yield * $quantity;
        } else {
            die(dump('Let Dale know this shouldn\'t have happened'));
        }
    }

    /**
     * Returns total cost of ingredients in a recipe
     *
     * @param $recipe
     * @return int
     */
    public static function CalcRecipeCost($recipe)
    {
        $elements = RecipeElement::where('recipe_id', '=', $recipe)->get();
        $recipe = new \stdClass();
        $ingredient = new \stdClass();
        $recipe->cost = 0;

        // Cycle through each ingredient, calculate cost, and add to the total cost;
        foreach ($elements as $element) {
            $ingredient->cost = Math::CalcIngredientCost(
                $element->master_list_id,
                $element->quantity,
                $element->unit_id
            );
            if ($ingredient->cost != -1) {
                $recipe->cost += $ingredient->cost;
            }
        }
        return $recipe->cost;
    }

    /**
     * Returns recipe cost percentage by dividing cost of ingredients by menu price.
     *
     * @param $recipeID
     * @return string
     */
    public static function CalcRecipeCostPercent($recipeID)
    {
        $recipe = Recipe::find($recipeID);
        $recipe->cost = Math::CalcRecipeCost($recipeID);

        // Divide total cost by menu price and return percentage.
        return number_format(($recipe->cost / $recipe->menu_price * 100), 2);
    }

    /**
     * Determines the Small Unit for a master_list entry based on type and system.
     *
     * @param $ap_unit
     * @return int|null
     */
    public static function GetApSmallUnit($ap_unit)
    {
        $units = DB::table('units')->select('system', 'weight')->where('id', '=', $ap_unit)->first();
        switch (true) {
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
            //General, Return same
            default:
                $SmallUnit = $ap_unit;
                break;
        }
        return $SmallUnit;
    }
}
