<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spp extends Model
{
  protected $table = 'spp';
  protected $guarded = [];
  // PARENT
  function siswa(){
    return $this->belongsTo('App\siswa', 'siswa_id', 'siswa_id');
  }
}
