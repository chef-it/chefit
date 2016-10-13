<?php

namespace App\Classes;
use App\MasterList;
use Illuminate\Support\Facades\DB;
use App\Units;
use Auth;

class DesignHelper{
    /**
     * Creates array to pass to Blade Form::Select of all measurement units.
     *
     * @return array
     */
    public static function UnitsDropDown(){
        $units = Units::orderBy('system', 'DESC')->orderby('order')->get();
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
}