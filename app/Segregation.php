<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Segregation extends Model
{
    public function QuestionTypes(){
        return $this->hasOne(QuestionTypes::class,'id','question_type_id');
    }
}
