<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class RecipeElement extends Model
{
    public function masterlist()
    {
        return $this->hasOne('App\MasterList', 'id', 'master_list_id');
    }

    public function unit()
    {
        return $this->hasOne('App\Unit', 'id', 'unit_id');
    }
}
