<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

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
class Unit extends Model
{
    //
}
