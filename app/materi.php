<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class materi extends Model
{
  protected $table = 'materi';
  protected $guarded = [];
  // PARENT
  function rpp(){
    return $this->belongsTo('App\rpp', 'rpp_id', 'rpp_id');
  }
}
