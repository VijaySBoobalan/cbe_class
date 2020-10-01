<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeesAssignDepartment extends Model
{
    public function ClassSection(){
        return $this->hasOne(ClassSection::class,"id","section");
    }

    public function FeesGroup(){
        return $this->hasOne(FeesGroup::class,"id","fee_group_id");
    }

    public function getFeesMaster(){
        return $this->hasOne(FeesMaster::class,"id","fee_group_id");
    }

    public function FeeMaster(){
        return $this->hasOne(FeesMaster::class,"id","fee_id");
    }

    public function getFeesType(){
        return $this->hasOne(FeesType::class,"id","fee_id");
    }
}
