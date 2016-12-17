<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 
        'metric', 
        'currency',
    ];
}
