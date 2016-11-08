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
        $direction = (Auth::user()->profile->metric == 0) ? 'ASC' : 'DESC';
        $units = Unit::orderBy('system', $direction)->orderby('order')->get();
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
            ->where('user_id', '=', Auth::user()->id)
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
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        if (!$ingredients->count()) {
            return [];
        }

        foreach ($ingredients as $ingredient) {
            $select[$ingredient->vendor] = $ingredient->vendor;
        }

        return $select;
    }

    public static function MasterListCategoriesDropDown()
    {
        $ingredients = MasterList::distinct()
            ->select('category')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        
        if (!$ingredients->count()) {
            return [];
        }

        foreach ($ingredients as $ingredient) {
            $select[$ingredient->category] = $ingredient->category;
        }

        return $select;
    }
    
    public static function SystemDropDown()
    {
        return array(
            '0'=>'US System',
            '1'=>'Metric System'
        );
    }
    
    public static function CurrencyDropDown()
    {
        return array(
            'AUD'=>'Australian Dollar',
            'BRL'=>'Brazilian Real',
            'CAD'=>'Canadian Dollar',
            'CZK'=>'Czech Koruna',
            'DKK'=>'Danish Krone',
            'EUR'=>'Euro',
            'HKD'=>'Hong Kong Dollar',
            'HUF'=>'Hungarian Forint',
            'ILS'=>'Israeli New Sheqel',
            'JPY'=>'Japanese Yen',
            'MYR'=>'Malaysian Ringgit',
            'MXN'=>'Mexican Peso',
            'NOK'=>'Norwegian Krone',
            'NZD'=>'New Zealand Dollar',
            'PHP'=>'Philippine Peso',
            'PLN'=>'Polish Zloty',
            'GBP'=>'Pound Sterling',
            'SGD'=>'Singapore Dollar',
            'SEK'=>'Swedish Krona',
            'CHF'=>'Swiss Franc',
            'TWD'=>'Taiwan New Dollar',
            'THB'=>'Thai Baht',
            'TRY'=>'Turkish Lira',
            'USD'=>'USD');
    }

    public static function CurrencySymbol()
    {
        switch (Auth::user()->profile->currency){
            case 'CZK':
                return '&#x4b;&#x10d;';
            case 'DKK':
                return 'kr';
            case 'EUR':
                return '&#8364;';
            case 'HUF':
                return 'Ft';
            case 'ILS':
                return '&#8362;';
            case 'JPY':
                return '&#165;';
            case 'MYR':
                return 'RM';
            case 'NOK':
                return 'kr';
            case 'PHP':
                return '&#8369;';
            case 'PLN':
                return 'zł';
            case 'GBP':
                return '&#163;';
            case 'SEK':
                return 'kr';
            case 'CHF':
                return 'Fr';
            case 'THB':
                return '&#3647;';
            case 'TRY':
                return 'TL';
            default:
                return "$";
        }
    }
}
