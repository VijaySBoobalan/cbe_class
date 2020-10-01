<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    public function getChapterDetails()
    {
        return $this->hasMany("App\ChapterDetails","chapter_id","id");
    }

    public function QuestionTypes(){
        return $this->hasOne(QuestionTypes::class,'id','question_type_id');
    }

    public function QuestionModel(){
        return $this->hasOne(QuestionModel::class,'id','question_model');
    }
    public function Segregation(){
        return $this->hasOne(Segregation::class,'id','segregation_id');
    }
}
