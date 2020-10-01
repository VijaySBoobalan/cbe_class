<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeGroupTypeDetails extends Model
{
    public function getFeesTypeDetails(){
        return $this->hasOne(FeesType::class,"id","fee_name_id");
    }

    public function getFeesTypeAmountDetails(){
        return $this->hasOne(FeesType::class,"id","fee_name_id");
    }
}
