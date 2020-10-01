<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChapterBasedQuestionDetails extends Model
{
    public function Segregation(){
        return $this->hasOne(Segregation::class,'id','segregation_id');
    }
	 public function Questions(){
        return $this->hasOne(Questions::class,'id','question_id');
    }
}
