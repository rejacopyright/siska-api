<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
  protected $table = 'kelas';
  protected $guarded = [];
  // RELATIONSHIP
  function wali_kelas(){
    return $this->belongsTo('App\Admin', 'wali', 'admin_id');
  }
}
