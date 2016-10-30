<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterListPriceTracking extends Model
{
    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'ap_unit');
    }
}
