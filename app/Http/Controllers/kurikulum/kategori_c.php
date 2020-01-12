<?php

namespace App\Http\Controllers\kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kurikulum_kategori as kategori;
use App\kurikulum_mapel as mapel;

class kategori_c extends Controller
{
  function kategori(){
    return kategori::orderBy('updated_at', 'DESC')->paginate(10)->all();
  }
  function kategori_select(){
    $kategori = kategori::orderBy('updated_at', 'DESC')->paginate(10)->map(function($i){
      $x['id'] = $i->kategori_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $kategori;
  }
  function store(Request $data){
    $exist = kategori::where('nama', $data->nama)->count();
    $kategori_id = kategori::max('kategori_id')+1;
    $kategori = new kategori;
    $kategori->kategori_id = $kategori_id;
    $kategori->nama = $data->nama;
    if (!$exist) {
      $kategori->save();
    }
    return ['update' => $kategori, 'kategori' => $this->kategori()];
  }
  function update(Request $data){
    $exist = kategori::where('nama', $data->nama)->count();
    $kategori = kategori::where('kategori_id', $data->kategori_id)->first();
    $kategori->nama = $data->nama;
    if (!$exist) {
      $kategori->save();
    }
    return ['update' => $kategori, 'kategori' => $this->kategori()];
  }
  function delete(Request $data){
    $kategori = kategori::where('kategori_id', $data->kategori_id)->first();
    $mapel = mapel::where('kategori_id', $data->kategori_id)->delete();
    $kategori->delete();
    return ['update' => $kategori, 'kategori' => $this->kategori()];
  }
}
