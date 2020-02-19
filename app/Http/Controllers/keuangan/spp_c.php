<?php

namespace App\Http\Controllers\keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\spp;

class spp_c extends Controller
{
  function spp(Request $data){
    $page = spp::orderBy('kelas_id', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $spp = $page->map(function($i){
      $i->admin;
      $i->kelas;
      $i->mapel;
      return $i;
    });
    return compact('spp', 'page');
  }
  function spp_select(Request $data){
    $spp = spp::orderBy('kelas_id', 'DESC');
    if ($data->q) { $spp = $spp->where('nama', 'like', '%'.$data->q.'%'); }
    $spp = $spp->paginate(10)->map(function($i){
      $x['id'] = $i->spp_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $spp;
  }
  function store(Request $data){
    $spp_id = spp::max('spp_id')+1;
    $spp = new spp;
    $spp->spp_id = $spp_id;
    $spp->admin_id = $data->admin_id;
    $spp->kelas_id = $data->kelas_id;
    $spp->mapel_id = $data->mapel_id;
    $spp->status = $data->status;
    $spp->save();
    return ['update' => $spp, 'spp' => $this->spp($data)['spp']];
  }
  function update(Request $data){
    $spp = spp::where('spp_id', $data->spp_id)->first();
    $spp->admin_id = $data->admin_id;
    $spp->kelas_id = $data->kelas_id;
    $spp->mapel_id = $data->mapel_id;
    $spp->status = $data->status ?? 0;
    $spp->save();
    return ['update' => $spp, 'spp' => $this->spp($data)['spp']];
  }
  function delete(Request $data){
    $spp = spp::where('spp_id', $data->spp_id)->first();
    $admin = admin::where('spp_id', $data->spp_id)->update(['spp_id'=> null]);
    $spp->delete();
    return ['update' => $spp, 'spp' => $this->spp($data)['spp']];
  }
}
