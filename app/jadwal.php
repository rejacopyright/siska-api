<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jadwal extends Model
{
  protected $table = 'jadwal';
  protected $guarded = [];
  // RELATIONSHIP
  function kelas(){
    return $this->belongsTo('App\kelas', 'kelas_id', 'kelas_id');
  }
  function hari(){
    return $this->belongsTo('App\hari', 'hari_id', 'hari_id');
  }
  function mapel(){
    return $this->belongsTo('App\kurikulum_mapel', 'mapel_id', 'mapel_id');
  }
}
