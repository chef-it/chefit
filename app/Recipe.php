<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public function elements()
    {
        return $this->hasMany('App\RecipeElement');
    }
    
    public function batchUnit()
    {
        return $this->hasOne('App\Unit', 'id', 'batch_unit');
    }
}
