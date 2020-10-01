<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class FeesCollection extends Model
{
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    public function ClassSection(){
        return $this->hasOne(ClassSection::class,"id","section_id");
    }

    public function Student(){
        return $this->hasOne(Student::class,'id','student_id');
    }
}
