<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kurikulum_kategori extends Model
{
  protected $table = 'kurikulum_kategori';
  protected $guarded = [];
  // RELATIONSHIP
  function mapel(){
    return $this->hasMany('App\kurikulum_mapel', 'kategori_id', 'kategori_id');
  }
}
