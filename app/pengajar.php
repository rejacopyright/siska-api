<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pengajar extends Model
{
  protected $table = 'pengajar';
  protected $guarded = [];
  // PARENT
  function admin(){
    return $this->belongsTo('App\Admin', 'admin_id', 'admin_id');
  }
  function kelas(){
    return $this->belongsTo('App\kelas', 'kelas_id', 'kelas_id');
  }
  function mapel(){
    return $this->belongsTo('App\kurikulum_mapel', 'mapel_id', 'mapel_id');
  }
}
