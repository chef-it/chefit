<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Math;

class Recipe extends Model
{

    protected $appends = array('data');

    public function getDataAttribute()
    {
        return Math::CalcRecipeData($this);
    }

    public function getPortionsPerBatchAttribute($value)
    {
        return $value + 0;
    }

    public function getBatchQuantityAttribute($value)
    {
        return $value + 0;
    }

    public function elements()
    {
        return $this->hasMany('App\RecipeElement');
    }
    
    public function batchUnit()
    {
        return $this->hasOne('App\Unit', 'id', 'batch_unit');
    }

    public function getMenuPriceAttribute($MenuPrice)
    {
        return number_format($MenuPrice, 2);
    }
}
