<?php

namespace App\Http\Controllers\keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use App\siswa;
use App\spp;
use App\keuangan_setting as setting;

class spp_c extends Controller
{
  function spp(Request $data){
    $page = spp::orderBy('periode', 'DESC');
    if ($data->q) {
      $siswa_id = siswa::where('nama', 'like', '%'.$data->q.'%')->orWhere('nis', 'like', '%'.$data->q.'%')->select('siswa_id')->pluck('siswa_id')->all();
      $page->whereIn('siswa_id', $siswa_id);
    }
    $page = $page->paginate(10);
    $spp = $page->map(function($i){
      $i->siswa;
      return $i;
    });
    $nominal = setting::first()->spp ?? 0;
    return compact('spp', 'page', 'nominal');
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
    $spp->siswa_id = $data->siswa_id;
    $spp->tgl = now();
    $spp->periode = $data->periode;
    $spp->nominal = str_replace('.','',$data->nominal ?? 0) ?? null;
    $spp->status = 1;
    $spp->keterangan = $data->keterangan;
    $spp->save();
    return ['update' => $spp, 'spp' => $this->spp($data)['spp']];
  }
  function update(Request $data){
    $spp = spp::where('spp_id', $data->spp_id)->first();
    if ($data->siswa_id) { $spp->siswa_id = $data->siswa_id; }
    $spp->tgl = now();
    if ($data->periode) { $spp->periode = $data->periode; }
    if ($data->nominal) { $spp->nominal = str_replace('.','',$data->nominal ?? 0) ?? null; }
    if ($data->keterangan) { $spp->keterangan = $data->keterangan; }
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
