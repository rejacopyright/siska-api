<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rpp extends Model
{
  protected $table = 'rpp';
  protected $guarded = [];
  // PARENT
  function silabus(){
    return $this->belongsTo('App\silabus', 'silabus_id', 'silabus_id');
  }
}
