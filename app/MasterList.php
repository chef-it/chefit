<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class MasterList extends Model
{
    protected $table = 'master_list';

    protected $fillable = [
        'name',
        'price',
        'ap_quantity',
        'ap_unit',
        'yield',
        'ap_small_price',
        'vendor',
        'category'
    ];
    
    public function conversion()
    {
        return $this->hasOne('App\Conversion');
    }

    public function priceTracking()
    {
        return $this->hasMany('App\MasterListPriceTracking');
    }
    
    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'ap_unit');
    }

    public function elements()
    {
        return $this->hasMany('App\RecipeElement');
    }

    public function getYieldAttribute($yield)
    {
        return $yield * 100;
    }
    
}
