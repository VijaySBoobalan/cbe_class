<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAssignFeesDetails extends Model
{
    public function getStudentDetail(){
        return $this->hasOne('App\Student', 'id', 'student_id')->select(['student_name','id']);;
    }

    public function StudentAssignFees()
    {
        return $this->hasOne(StudentAssignFees::class, 'id', 'student_assign_fee_id')->with('getFeeFeesGroup','getDepartment');
    }

    public function ClassSection()
    {
        return $this->hasOne(ClassSection::class, 'id', 'class_id');
    }

    public function getFeesMasterName(){
        return $this->hasOne(FeesMaster::class,"id","fee_type");
    }

    public function getGroupDetails(){
        return $this->hasMany(FeeGroupTypeDetails::class,"fee_group_type_id","feesgroup_id");
    }
}
