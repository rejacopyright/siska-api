<?php

namespace App\indonesia;

use Illuminate\Database\Eloquent\Model;

class kota extends Model
{
  protected $connection = 'indonesia';
  protected $table = 'kota';
  public $timestamps = false;
  protected $guarded = [];
  // RELATIONSHIP
  function provinsi(){
    return $this->belongsTo('App\indonesia\provinsi', 'provinsi_id', 'provinsi_id');
  }
  function kecamatan(){
    return $this->hasMany('App\indonesia\kecamatan', 'kota_id', 'kota_id');
  }
}
