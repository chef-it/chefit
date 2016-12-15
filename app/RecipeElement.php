<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class RecipeElement extends Model
{
    public function masterlist()
    {
        return $this->hasOne('App\MasterList', 'id', 'master_list_id');
    }
    
    public function subrecipe()
    {
        return $this->hasOne('App\Recipe', 'id', 'sub_recipe_id');
    }

    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'unit_id');
    }
    
    public function recipe()
    {
        return $this->hasOne('App\Recipe', 'id', 'recipe_id');
    }

    public function getQuantityAttribute($value)
    {
        return $value + 0;
    }

    public function getCostAttribute($value)
    {
        return number_format($value, 2);
    }
}
