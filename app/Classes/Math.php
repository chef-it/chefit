<?php

namespace App\Classes;
use App\MasterList;
use Illuminate\Support\Facades\DB;
use App\Units;
use Auth;

class Math {

    /**
     * Creates array to pass to Blade Form::Select of all measurement units.
     *
     * @return array
     */
    public static function UnitsDropDown(){
        $units = DB::table('units')->orderBy('system', 'DESC')->orderby('order')->get();
        $select = array();

        foreach($units as $unit){
            switch($unit->system){
                case 1:
                    $unit->system = "US System";
                    break;
                case 2:
                    $unit->system = "General";
                    break;
                case 3:
                    $unit->system = "Metric System";
                    break;
            }
            $select[$unit->system][$unit->id] = $unit->name;
        }

        return $select;
    }

    /**
     * Creates array to pass to Blade Form::Select of all masterlist items.
     *
     * @return array
     */
    public static function IngredientsDropDown(){
        $ingredients = MasterList::select('id', 'name')
            ->where('owner', '=', Auth::user()->id)
            ->orderBy('name')->get();

        foreach($ingredients as $ingredient){
            $select[$ingredient->id] = $ingredient->name;
        }

        return $select;
    }

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