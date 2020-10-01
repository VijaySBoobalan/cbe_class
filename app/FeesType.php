<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeesType extends Model
{
    public function getFeesMasterName(){
        return $this->hasOne(FeesMaster::class,"id","fee_type");
    }
}
