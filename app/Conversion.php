<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    public function leftUnit(){
        return $this->hasOne('App\Unit', 'id', 'left_unit');
    }

    public function rightUnit(){
        return $this->hasONe('App\Unit', 'id', 'right_unit');
    }
}
