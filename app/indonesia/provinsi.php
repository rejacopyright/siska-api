<?php

namespace App\indonesia;

use Illuminate\Database\Eloquent\Model;

class provinsi extends Model
{
  protected $connection = 'indonesia';
  protected $table = 'provinsi';
  public $timestamps = false;
  protected $guarded = [];
  // RELATIONSHIP
  function kota(){
    return $this->hasMany('App\indonesia\kota', 'provinsi_id', 'provinsi_id');
  }
}
