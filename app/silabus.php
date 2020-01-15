<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class silabus extends Model
{
  protected $table = 'silabus';
  protected $guarded = [];
  // PARENT
  function mapel(){
    return $this->belongsTo('App\kurikulum_mapel', 'mapel_id', 'mapel_id');
  }
  function kelas(){
    return $this->belongsTo('App\kelas', 'kelas_id', 'kelas_id');
  }
  function semester(){
    return $this->belongsTo('App\semester', 'semester_id', 'semester_id');
  }
  // CHILD
  function rpp(){
    return $this->hasMany('App\rpp', 'silabus_id', 'silabus_id');
  }
}
