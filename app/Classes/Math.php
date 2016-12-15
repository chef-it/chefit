<?php
namespace App\Classes;

use App\Recipe;
use App\RecipeElement;
use Illuminate\Support\Facades\DB;
use App\Unit;
use Auth;

/**
 * Class Math
 * @package App\Classes
 */
abstract class Math
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
    public static function CalcIngredientCost(RecipeElement $element)
    {
        $pause = 1;
        // Get units record for master_list small unit
        $inputUnit = $element->masterlist->unit;
        $outputUnit = $element->unit;
        $quantity = $element->quantity;

        $pause = 1;

        // If a weight-volume conversion is required
        if ($inputUnit->weight != $outputUnit->weight) {
            $conversion = $element->masterlist->conversion;
            if (count($conversion)) {
                $conversionFactor = $conversion->right_quantity / $conversion->left_quantity;
                // Calculate Conversion
                if ($inputUnit->system == $conversion->leftUnit->system && $inputUnit->weight == $conversion->leftUnit->weight) {
                    $element->masterlist->ap_small_price /= $conversionFactor * $conversion->rightUnit->factor;
                    $inputUnit = $conversion->rightUnit;
                } elseif ($inputUnit->system == $conversion->rightUnit->system && $inputUnit->weight == $conversion->rightUnit->weight) {
                    $element->masterlist->ap_small_price *= $conversionFactor / $conversion->leftUnit->factor;
                    $inputUnit = $conversion->leftUnit;
                } else {
                    // Return -1 to trigger button on recipes.elements.index letting the user know the conversion
                    // set up doesn't account for measurements entered into to recipe ingredient.
                    return -1;
                }
            } else {
                // Return -1 to trigger button on recipes.elements.index letting the user know there isn't a conversion
                // set up.
                return -1;
            }
        }


        if ($inputUnit->system == 2 || $outputUnit->system == 2) {
            // Each
            if ($inputUnit->id == 15) {
                return $element->masterlist->ap_small_price * $element->masterlist->unit->factor * $quantity;
            }
        }

        // If input and output are different systems, but same type, convert input to output system,
        // modify the ingredient price to reflect new change, and continue on.
        if ($inputUnit->system != $outputUnit->system && $inputUnit->weight == $outputUnit->weight) {
            if ($inputUnit->weight == 1) {
                // We're dealing with weight
                if ($outputUnit->system == 1) {
                    // Input needs converted from grams to oz
                    $element->masterlist->ap_small_price /= 0.0352739619;
                    $inputUnit->system = 1;
                    $inputUnit->id = 1;
                    $inputUnit->name = 'oz';
                } else {
                    // Input needs converted from oz to gram
                    $element->masterlist->ap_small_price *= 0.0352739619;
                    $inputUnit->system = 3;
                    $inputUnit->id = 3;
                    $inputUnit->name = 'gram';
                }
            } else {
                // We're dealing with volume
                if ($outputUnit->system == 1) {
                    // Input needs converted from mL to fl-oz
                    $element->masterlist->ap_small_price /= 0.033814;
                    $inputUnit->system = 1;
                    $inputUnit->id = 2;
                    $inputUnit->name = 'fl oz';
                } else {
                    // Input needs converted from fl-oz to mL
                    $element->masterlist->ap_small_price *= 0.033814;
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
            return $element->masterlist->ap_small_price * $outputUnit->factor * $element->masterlist->yield * $quantity / 100;
        } else {
            die(dump('Let Dale know this shouldn\'t have happened'));
        }
    }

    public static function CalcElementCost(RecipeElement $element)
    {
        $pause = 1;

        if ($element->type == 'masterlist') {
            $cost = Math::CalcIngredientCost($element);
        } else if ($element->type == 'recipe') {
            $cost = Math::CalcSubRecipeCost($element);
        }

        if ($element->type == 'masterlist' && $cost == -1) {
            return link_to_route('masterlist.conversions.index', 'Conversion', [$element->master_list_id], ['class' => 'btn btn-xs btn-danger btn-block']);
        } else if ($element->type == 'recipe' && $cost == -1) {
            return 'I didn\'t account for this calculation. Please let me know I need to add it';
        } else {
            return number_format($cost, 2);
        }
    }
    
    
    public static function CalcSubRecipeCost(RecipeElement $element)
    {
        //Get recipe data
        $recipe = $element->subrecipe;
        // Get units record for master_list small unit
        $inputUnit = $recipe->batchUnit;
        // Get units record for $unit
        $outputUnit = $element->unit;
        $quantity = $element->quantity;

        //If recipe calls for portion, return cost divided by portions per recipe.
        if ($outputUnit->id == 16) {
            return $recipe->cost / $recipe->portions_per_batch * $quantity;
        }

        //If recipe calls for each, and sub recipe is set to each, return cost divided by each.
        if ($outputUnit->id == 15 && $recipe->batch_unit = 15) {
            return $recipe->cost / $recipe->batch_quantity * $quantity;
        } else if ($outputUnit->id == 15) {
            //Recipe calls for each, sub recipe isn't set to each, so just return sub recipe cost.
            return $recipe->cost;
        }

        if ($inputUnit->system == $outputUnit->system && $inputUnit->weight == $outputUnit->weight) {
            $recipe->smallCost = $recipe->cost / $inputUnit->factor / $recipe->batch_quantity;
            return $recipe->smallCost * $outputUnit->factor * $quantity;
        } else {
            return -1;
        }
    }
    
    public static function CalcRecipeCost(Recipe $recipe)
    {
        if ($recipe->id == 1) {
            $pause=1;
        }
        $cost = 0.00;
        foreach ($recipe->elements as $element) {
            $cost += $element->cost;
        }
        return $cost;
    }
    
    public static function CalcCostPercent(Recipe $recipe)
    {
        if ($recipe->menu_price == 0) {
            return 0;
        } else {
            // Divide total cost by menu price and return percentage.
            return $recipe->cost / $recipe->menu_price * 100;
        }
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
