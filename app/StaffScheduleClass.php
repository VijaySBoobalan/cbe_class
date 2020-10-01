<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class StaffScheduleClass extends Model
{
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    public function Staff(){
        return $this->hasOne(Staff::class,'id','staff_id');
    }

    public function StaffSubjects(){
        return $this->hasMany(StaffScheduleSubjectDetails::class,'staff_schedule_class_id','id')->pluck('subject_id')->get('Subject');
    }

    public function ClassSection(){
        return $this->hasOne(ClassSection::class,'id','section_id');
    }
}
