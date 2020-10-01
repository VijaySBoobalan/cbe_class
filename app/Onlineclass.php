<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onlineclass extends Model
{
    protected $table = 'onlineclass';
    public function Staff()
    {
        return $this->hasOne(Staff::class,'id','staff_id');
    }
}
