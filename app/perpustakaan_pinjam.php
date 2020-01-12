<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class perpustakaan_pinjam extends Model
{
  protected $table = 'perpustakaan_pinjam';
  protected $guarded = [];
  // PARENT
  function siswa(){
    return $this->belongsTo('App\siswa', 'siswa_id', 'siswa_id');
  }
  function buku(){
    return $this->belongsTo('App\perpustakaan', 'perpustakaan_id', 'perpustakaan_id');
  }
}
