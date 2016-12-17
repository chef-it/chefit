<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * app\MasterList
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property float $ap_quantity
 * @property int $ap_unit
 * @property float $yield
 * @property float $ap_small_price
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $vendor
 * @property string $category
 * @property \Carbon\Carbon $deleted_at
 * @property-read \app\Conversion $conversion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MasterListPriceTracking[] $priceTracking
 * @property-read \app\Unit $unit
 * @property-read \Illuminate\Database\Eloquent\Collection|\app\RecipeElement[] $elements
 * @property-read \app\User $user
 * @property-read \App\InvoiceRecord $InvoiceRecord
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereApQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereApUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereYield($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereApSmallPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereVendor($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\app\MasterList whereDeletedAt($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsTo('App\InvoiceRecord');
    }

    public function getYieldAttribute($yield)
    {
        return $yield * 100;
    }
    
}
