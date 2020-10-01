<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class StaffScheduleSubjectDetails extends Model
{
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    public function Subject(){
        return $this->hasMany(Subject::class,'id','subject_id');
    }

    public function getSubject(){
        return $this->hasOne(Subject::class,'id','subject_id');
    }

    public function StaffScheduleClass(){
        return $this->hasOne(StaffScheduleClass::class,'id','staff_schedule_class_id');
    }
}
