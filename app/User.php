<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    public $with = ['StaffDetails'];

    use HasRoles,HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_id', 'user_type', 'country_code','mobile_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function StudentDetails(){
        return $this->hasOne(Student::class,'id','user_id');
    }

    public function StaffDetails(){
        return $this->hasOne(Staff::class,'id','user_id');
    }

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public function getPhoneNumber()
    {
        return $this->country_code.$this->mobile_number;
    }
}
