<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
