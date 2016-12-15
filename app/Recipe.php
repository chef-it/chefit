<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Math;

class Recipe extends Model
{

    public function getCostAttribute($value)
    {
        return number_format($value, 2);
    }
    
    public function getCostPercentAttribute($value)
    {
        return number_format($value, 2) + 0;
    }

    public function getPortionPriceAttribute($value)
    {
        return $value;
    }

    public function getPortionsPerBatchAttribute($value)
    {
        return $value + 0;
    }

    public function getBatchQuantityAttribute($value)
    {
        return $value + 0;
    }

    public function getMenuPriceAttribute($MenuPrice)
    {
        return number_format($MenuPrice, 2);
    }

    public function elements()
    {
        return $this->hasMany('App\RecipeElement');
    }
    
    public function batchUnit()
    {
        return $this->hasOne('App\Unit', 'id', 'batch_unit');
    }

    public function isSubRecipe()
    {
        return $this->hasMany('App\RecipeElement', 'sub_recipe_id', 'id');
    }
}
