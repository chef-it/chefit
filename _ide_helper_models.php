<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\UserProfile
 *
 * @property int $id
 * @property int $user_id
 * @property bool $metric
 * @property string $currency
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\UserProfile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserProfile whereMetric($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserProfile whereCurrency($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserProfile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class UserProfile extends \Eloquent {}
}

namespace App{
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
	class InvoiceRecord extends \Eloquent {}
}

namespace App{
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
	class Invoice extends \Eloquent {}
}

namespace App{
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
	class MasterListPriceTracking extends \Eloquent {}
}

namespace app{
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
	class MasterList extends \Eloquent {}
}

namespace app{
/**
 * app\Unit
 *
 * @property int $id
 * @property string $name
 * @property int $system
 * @property int $weight
 * @property int $order
 * @property float $factor
 * @method static \Illuminate\Database\Query\Builder|\app\Unit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\app\Unit whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\app\Unit whereSystem($value)
 * @method static \Illuminate\Database\Query\Builder|\app\Unit whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\app\Unit whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\app\Unit whereFactor($value)
 * @mixin \Eloquent
 */
	class Unit extends \Eloquent {}
}

