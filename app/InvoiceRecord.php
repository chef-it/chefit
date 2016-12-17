<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InvoiceRecord
 *
 * @property int $id
 * @property int $master_list_id
 * @property float $line_quantity
 * @property float $total_price
 * @property float $price
 * @property float $ap_quantity
 * @property int $ap_unit
 * @property string $category
 * @property int $invoice_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \app\MasterList $masterlist
 * @property-read \app\Unit $unit
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereMasterListId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereLineQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereTotalPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereApQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereApUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\InvoiceRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceRecord extends Model
{
    public function masterlist()
    {
        return $this->hasOne('App\MasterList', 'id', 'master_list_id')->withTrashed();
    }

    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'ap_unit');
    }

    public function getLineQuantityAttribute($value)
    {
        return $value + 0;
    }
}
