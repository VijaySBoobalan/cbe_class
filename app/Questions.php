<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    public function QuestionTypes(){
        return $this->hasOne(QuestionTypes::class,'id','question_type_id');
    }

    public function QuestionModel(){
        return $this->hasOne(QuestionModel::class,'id','question_model');
    }

    public function Segregation(){
        return $this->hasOne(Segregation::class,'id','segregation_id');
    }

    public function PreparationTypes(){
        return $this->hasOne(PreparationTypes::class,'id','preparation_type_id');
    }

    public function Chapter(){
        return $this->hasOne(Chapter::class,'id','chapter_id');
    }

    public function QuestionYears(){
        return $this->hasMany(QuestionYears::class,'question_id','id');
    }
}
