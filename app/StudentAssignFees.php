<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAssignFees extends Model
{
    public function getFeeFeesGroup()
    {
        return $this->hasOne('App\FeesGroup', 'id', 'fee_group_id')->with('getFeesGroupDetails');
    }

    public function ClassSection()
    {
        return $this->hasOne(ClassSection::class, 'id', 'section_id');
    }

    public function StudentAssignFees()
    {
        return $this->hasOne(StudentAssignFeesDetails::class, 'student_assign_fee_id', 'id');
    }


    public function StudentAssignFeesDetails()
    {
        return $this->hasMany(StudentAssignFeesDetails::class, 'student_assign_fee_id', 'id')->with('getStudentDetail');
    }
}
