<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class siswa extends Authenticatable
{
  use Notifiable;
  protected $guard = 'siswa';
  protected $table = 'siswa';
  protected $guarded = [];
  protected $hidden = [ 'password', 'remember_token' ];
  // PARENT
  function kelas(){
    return $this->belongsTo('App\kelas', 'kelas_id', 'kelas_id');
  }
}
