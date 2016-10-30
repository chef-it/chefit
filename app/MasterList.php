<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class MasterList extends Model
{
    protected $table = 'master_list';

    public function priceTracking()
    {
        return $this->hasMany('App\MasterListPriceTracking', 'master_list', 'id');
    }
    
    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'ap_unit');
    }
}
