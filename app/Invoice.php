<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function Records(){
        return $this->hasMany('App\InvoiceRecord');
    }
}
