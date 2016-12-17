<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MasterListPriceTracking
 *
 * @property int $id
 * @property int $master_list_id
 * @property int $user_id
 * @property float $price
 * @property float $ap_quantity
 * @property int $ap_unit
 * @property string $vendor
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \app\Unit $unit
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking whereMasterListId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking whereApQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking whereApUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking whereVendor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MasterListPriceTracking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MasterListPriceTracking extends Model
{
    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'ap_unit');
    }
}
