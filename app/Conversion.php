<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $fillable = [
        'left_quantity',
        'left_unit',
        'right_quantity',
        'right_unit'
    ];

    public function leftUnit()
    {
        return $this->hasOne('App\Unit', 'id', 'left_unit');
    }

    public function rightUnit()
    {
        return $this->hasONe('App\Unit', 'id', 'right_unit');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getLeftQuantityAttribute($leftQuantity)
    {
        return $leftQuantity + 0;
    }

    public function getRightQuantityAttribute($rightQuantity)
    {
        return $rightQuantity + 0;
    }
}
