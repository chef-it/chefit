<?php

namespace App\Classes;

use App\MasterList;
use Illuminate\Support\Facades\DB;
use App\Unit;
use Auth;

class DesignHelper
{
    public static function RecipeOptionsDropDown()
    {
        $select[0] = 'No';
        $select[1] = 'Yes';
        return $select;
    }

    /**
     * Creates array to pass to Blade Form::Select of all measurement units.
     *
     * @return array
     */
    public static function UnitsDropDown()
    {
        $units = Unit::orderBy('system')->orderby('order')->get();
        $select = array();

        foreach ($units as $unit) {
            switch ($unit->system) {
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
    public static function IngredientsDropDown()
    {
        $ingredients = MasterList::select('id', 'name')
            ->where('owner', '=', Auth::user()->id)
            ->orderBy('name')->get();

        foreach ($ingredients as $ingredient) {
            $select[$ingredient->id] = $ingredient->name;
        }

        return $select;
    }

    public static function VendorsDropDown()
    {
        $ingredients = MasterList::distinct()
            ->select('vendor')
            ->where('owner', '=', Auth::user()->id)
            ->get();

        foreach ($ingredients as $ingredient) {
            $select[$ingredient->vendor] = $ingredient->vendor;
        }

        return $select;
    }

    public static function MasterListCategoriesDropDown()
    {
        $ingredients = MasterList::distinct()
            ->select('category')
            ->where('owner', '=', Auth::user()->id)
            ->get();

        foreach ($ingredients as $ingredient) {
            $select[$ingredient->category] = $ingredient->category;
        }

        return $select;
    }
}
