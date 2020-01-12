<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class perpustakaan extends Model
{
  protected $table = 'perpustakaan';
  protected $guarded = [];
  // PARENT
  function kategori(){
    return $this->belongsTo('App\perpustakaan_kategori', 'kategori_id', 'kategori_id');
  }
  function koleksi(){
    return $this->belongsTo('App\perpustakaan_koleksi', 'koleksi_id', 'koleksi_id');
  }
  function penerbit(){
    return $this->belongsTo('App\perpustakaan_penerbit', 'penerbit_id', 'penerbit_id');
  }
}
