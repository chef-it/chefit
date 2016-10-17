<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class MasterList extends Model
{
    protected $table = 'master_list';

    public function conversion()
    {
        $this->hasOne('Conversion');
    }
}
