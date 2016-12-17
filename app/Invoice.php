<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Invoice
 *
 * @property int $id
 * @property string $vendor
 * @property string $invoice_number
 * @property int $user_id
 * @property float $grand_total
 * @property string $date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\InvoiceRecord[] $Records
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice whereVendor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice whereGrandTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    public function Records(){
        return $this->hasMany('App\InvoiceRecord');
    }
}
