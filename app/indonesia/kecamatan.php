<?php

namespace App\indonesia;

use Illuminate\Database\Eloquent\Model;

class kecamatan extends Model
{
  protected $connection = 'indonesia';
  protected $table = 'kecamatan';
  public $timestamps = false;
  protected $guarded = [];
  // RELATIONSHIP
  function kota(){
    return $this->belongsTo('App\indonesia\kota', 'kota_id', 'kota_id');
  }
  function desa(){
    return $this->hasMany('App\indonesia\desa', 'kecamatan_id', 'kecamatan_id');
  }
}
