<?php

namespace App\Http\Controllers\kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kurikulum_mapel as mapel;

class mapel_c extends Controller
{
  function mapel(Request $data){
    $page = mapel::orderBy('updated_at', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('updated_at', 'DESC')->paginate(10);
    $mapel = $page->map(function($i){
      $i->kategori;
      return $i;
    });
    return compact('mapel', 'page');
  }
  function mapel_select(Request $data){
    $mapel = mapel::orderBy('updated_at', 'DESC');
    if ($data->q) {
      $mapel = $mapel->where('nama', 'like', '%'.$data->q.'%');
    }
    $mapel = $mapel->paginate(10)->map(function($i){
      $x['id'] = $i->mapel_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $mapel;
  }
  function store(Request $data){
    $exist = mapel::where('nama', $data->nama)->count();
    $mapel_id = mapel::max('mapel_id')+1;
    $mapel = new mapel;
    $mapel->mapel_id = $mapel_id;
    $mapel->kategori_id = $data->kategori_id;
    $mapel->nama = $data->nama;
    if (!$exist) {
      $mapel->save();
    }
    return ['update' => $mapel, 'mapel' => $this->mapel($data)['mapel']];
  }
  function update(Request $data){
    $exist = mapel::where('nama', '!=', $data->nama)->where('nama', $data->nama)->count();
    $mapel = mapel::where('mapel_id', $data->mapel_id)->first();
    $mapel->nama = $data->nama;
    if ($data->kategori_id) { $mapel->kategori_id = $data->kategori_id; }
    if (!$exist) {
      $mapel->save();
    }
    return ['update' => $mapel, 'mapel' => $this->mapel($data)['mapel']];
  }
  function delete(Request $data){
    $mapel = mapel::where('mapel_id', $data->mapel_id)->first();
    $mapel->delete();
    return ['mapel' => $this->mapel($data)['mapel']];
  }
}
