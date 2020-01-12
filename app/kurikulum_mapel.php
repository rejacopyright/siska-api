<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kurikulum_mapel extends Model
{
  protected $table = 'kurikulum_mapel';
  protected $guarded = [];
  // RELATIONSHIP
  function kategori(){
    return $this->belongsTo('App\kurikulum_kategori', 'kategori_id', 'kategori_id');
  }
}
