<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Subject;

class StaffSubjectAssign extends Model
{
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    public function StaffSubject(){
        return $this->hasOne(Subject::class,'id','subjects');
    }

    public function Staff(){
        return $this->hasOne(Staff::class,'id','staff_id');
    }

    public function ClassSection(){
        return $this->hasOne(ClassSection::class,'id','section_id');
    }

    public function Chapters(){
        return $this->hasMany(Chapter::class,'staff_subject_assign_id','id');
    }
}
