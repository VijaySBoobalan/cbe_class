<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    public function StaffDetails(){
        return $this->hasOne(Staff::class,'id','staff_id');
    }

    public function ClassSection(){
        return $this->hasOne(ClassSection::class,'id','section_id');
    }

    public function StaffSubject(){
        return $this->hasOne(Subject::class,'id','subject_id');
    }
}
