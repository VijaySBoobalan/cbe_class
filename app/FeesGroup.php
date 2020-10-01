<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeesGroup extends Model
{
    public function getFeesMasterName(){
        return $this->hasOne(FeesMaster::class,"id","fee_type");
    }

    public function getFeesType(){
        return $this->hasOne(FeesType::class,"id","fee_type");
    }

    public function getFeesGroupDetails(){
        return $this->hasMany(FeeGroupTypeDetails::class,"fee_group_type_id","id")->with(['getFeesTypeAmountDetails']);
    }

    public function getGroupDetails(){
        return $this->hasMany(FeeGroupTypeDetails::class,"fee_group_type_id","formgroup_id")->with(['getFeesTypeAmountDetails']);
    }
}
