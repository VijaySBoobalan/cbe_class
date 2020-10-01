<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
    protected $fillable = [
        'instution_name', 'instution_address', 'user_name','phone_number_1', 'phone_number_2', 'email', 'password',
    ];
}
