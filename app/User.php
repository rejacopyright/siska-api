<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $guard = 'web';
    protected $table = 'users';
    protected $guarded = [];
    protected $hidden = [ 'password', 'remember_token' ];
}
