<?php

namespace App;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminEmailVerificationNotification;
use App\Notifications\AdminResetPasswordNotification as Notification;

class Student extends Authenticatable
{

    use Notifiable;

    protected $guard = 'student';

    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    public function StudentDetails(){
        return $this->hasOne(User::class,'user_id','id');
    }

    public function ClassSection(){
        return $this->hasOne(ClassSection::class,'id','section_id');
    }
}
