<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sdm_jabatan extends Model
{
  protected $table = 'sdm_jabatan';
  protected $guarded = [];
  // RELATIONSHIP
  function user(){
    return $this->hasMany('App\User', 'jabatan_id', 'jabatan_id');
  }
}
