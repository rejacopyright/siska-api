<?php

namespace App\Http\Controllers\kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\rpp;
use App\Admin as admin;

class rpp_c extends Controller
{
  function rpp(Request $data){
    $page = rpp::orderBy('updated_at', 'DESC');
    if ($data->q) {
      $page->where('kd', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $rpp = $page->map(function($i){
      $i->silabus;
      $i['mapel'] = $i->silabus->mapel;
      $i['kelas'] = $i->silabus->kelas;
      $i['semester'] = $i->silabus->semester;
      return $i;
    });
    return compact('rpp', 'page');
  }
  function detail($rpp_id){
    $rpp = rpp::where('rpp_id', $rpp_id)->first();
    $rpp->kelas = $rpp->silabus->kelas->nama;
    $rpp->semester = $rpp->silabus->semester->nama;
    $rpp->mapel = $rpp->silabus->mapel->nama;
    $rpp->sk = $rpp->silabus->sk;
    return $rpp;
  }
  function rpp_select(Request $data){
    $rpp = rpp::orderBy('updated_at', 'DESC');
    if ($data->q) { $rpp = $rpp->where('kd', 'like', '%'.$data->q.'%'); }
    $rpp = $rpp->paginate(10)->map(function($i){
      $x['id'] = $i->rpp_id;
      $x['text'] = $i->kd.' (K:'.$i->silabus->kelas->nama.' | S:'.$i->silabus->semester->nama.' | M:'.$i->silabus->mapel->nama.')';
      return $x;
    });
    return $rpp;
  }
  function store(Request $data){
    $rpp_id = rpp::max('rpp_id')+1;
    $rpp = new rpp;
    $rpp->rpp_id = $rpp_id;
    $rpp->silabus_id = $data->silabus_id;
    $rpp->kd = $data->kd;
    $rpp->save();
    return ['update' => $rpp, 'rpp' => $this->rpp($data)['rpp']];
  }
  function update(Request $data){
    $rpp = rpp::where('rpp_id', $data->rpp_id)->first();
    if ($data->silabus_id) { $rpp->silabus_id = $data->silabus_id; }
    if ($data->kd) { $rpp->kd = $data->kd; }
    $rpp->save();
    return ['update' => $rpp, 'rpp' => $this->rpp($data)['rpp']];
  }
  function delete(Request $data){
    $rpp = rpp::where('rpp_id', $data->rpp_id)->first();
    $admin = admin::where('rpp_id', $data->rpp_id)->update(['rpp_id'=> null]);
    $rpp->delete();
    return ['update' => $rpp, 'rpp' => $this->rpp($data)['rpp']];
  }
}
