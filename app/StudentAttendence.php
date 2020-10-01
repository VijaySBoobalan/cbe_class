<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAttendence extends Model
{
    public function Student(){
        return $this->hasOne(Student::class,'id','student_id');
    }

    public function ClassSection(){
        return $this->hasOne(ClassSection::class,'id','section_id');
    }

    public function Subject(){
        return $this->hasOne(Subject::class,'id','subject_id');
    }
}
