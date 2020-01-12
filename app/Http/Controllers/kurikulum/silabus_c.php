<?php

namespace App\Http\Controllers\kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\silabus;
use App\Admin as admin;

class silabus_c extends Controller
{
  function silabus(Request $data){
    $page = silabus::orderBy('kelas_id')->orderBy('semester_id');
    if ($data->q) {
      $page->where('sk', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $silabus = $page->map(function($i){
      $i->mapel;
      $i->kelas;
      $i->semester;
      return $i;
    });
    return compact('silabus', 'page');
  }
  function silabus_select(Request $data){
    $silabus = silabus::orderBy('kelas_id')->orderBy('semester_id');
    if ($data->q) { $silabus = $silabus->where('sk', 'like', '%'.$data->q.'%'); }
    $silabus = $silabus->paginate(10)->map(function($i){
      $x['id'] = $i->silabus_id;
      $x['text'] = $i->sk.' (K:'.$i->kelas->nama.' | S:'.$i->semester->nama.' | M:'.$i->mapel->nama.')';
      return $x;
    });
    return $silabus;
  }
  function silabus_select_filter(Request $data, $kelas_id, $semester_id, $mapel_id){
    $silabus = silabus::orderBy('kelas_id')->orderBy('semester_id');
    if ($kelas_id) { $silabus = $silabus->where('kelas_id', $kelas_id); }
    if ($semester_id) { $silabus = $silabus->where('semester_id', $semester_id); }
    if ($mapel_id) { $silabus = $silabus->where('mapel_id', $mapel_id); }
    if ($data->q) { $silabus = $silabus->where('sk', 'like', '%'.$data->q.'%'); }
    $silabus = $silabus->paginate(10)->map(function($i){
      $x['id'] = $i->silabus_id;
      $x['text'] = $i->sk;
      return $x;
    });
    return $silabus;
  }
  function store(Request $data){
    $exist = silabus::where('mapel_id', $data->mapel_id)->where('kelas_id', $data->kelas_id)->where('semester_id', $data->semester_id)->count();
    $silabus_id = silabus::max('silabus_id')+1;
    $silabus = new silabus;
    $silabus->silabus_id = $silabus_id;
    $silabus->mapel_id = $data->mapel_id;
    $silabus->kelas_id = $data->kelas_id;
    $silabus->semester_id = $data->semester_id;
    $silabus->sk = $data->sk;
    if (!$exist) {
      $silabus->save();
    }
    return ['update' => $silabus, 'silabus' => $this->silabus($data)['silabus']];
  }
  function update(Request $data){
    $exist = silabus::where('silabus_id', '!=', $data->silabus_id)->where('mapel_id', $data->mapel_id)->where('kelas_id', $data->kelas_id)->where('semester_id', $data->semester_id)->count();
    $silabus = silabus::where('silabus_id', $data->silabus_id)->first();
    if ($data->mapel_id) { $silabus->mapel_id = $data->mapel_id; }
    if ($data->kelas_id) { $silabus->kelas_id = $data->kelas_id; }
    if ($data->semester_id) { $silabus->semester_id = $data->semester_id; }
    if ($data->sk) { $silabus->sk = $data->sk; }
    if (!$exist) {
      $silabus->save();
    }
    return ['update' => $silabus, 'silabus' => $this->silabus($data)['silabus']];
  }
  function delete(Request $data){
    $silabus = silabus::where('silabus_id', $data->silabus_id)->first();
    $admin = admin::where('silabus_id', $data->silabus_id)->update(['silabus_id'=> null]);
    $silabus->delete();
    return ['update' => $silabus, 'silabus' => $this->silabus($data)['silabus']];
  }
}
