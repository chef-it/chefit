<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterList extends Model
{
    use SoftDeletes;

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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
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

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function InvoiceRecord()
    {
        return $this->belongsTo('App\InvoiceRecord')->withTrashed();
    }

    public function getYieldAttribute($yield)
    {
        return $yield * 100;
    }
    
}
