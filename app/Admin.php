<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';
    protected $table = 'admin';
    protected $guarded = [];
    protected $hidden = [ 'password', 'remember_token' ];
    // RELATIONSHIP
    function jabatan(){
      return $this->belongsTo('App\sdm_jabatan', 'jabatan_id', 'jabatan_id');
    }
}
