<?php

namespace App\indonesia;

use Illuminate\Database\Eloquent\Model;

class desa extends Model
{
  protected $connection = 'indonesia';
  protected $table = 'desa';
  public $timestamps = false;
  protected $guarded = [];
  // RELATIONSHIP
  function kecamatan(){
    return $this->belongsTo('App\indonesia\kecamatan', 'kecamatan_id', 'kecamatan_id');
  }
}
