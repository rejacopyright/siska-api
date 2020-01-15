<?php

namespace App\Http\Controllers\sdm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\pengajar;

class pengajar_c extends Controller
{
  function pengajar(Request $data){
    $page = pengajar::orderBy('kelas_id', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $pengajar = $page->map(function($i){
      $i->admin;
      $i->kelas;
      $i->mapel;
      return $i;
    });
    return compact('pengajar', 'page');
  }
  function pengajar_select(Request $data){
    $pengajar = pengajar::orderBy('kelas_id', 'DESC');
    if ($data->q) { $pengajar = $pengajar->where('nama', 'like', '%'.$data->q.'%'); }
    $pengajar = $pengajar->paginate(10)->map(function($i){
      $x['id'] = $i->pengajar_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $pengajar;
  }
  function store(Request $data){
    $pengajar_id = pengajar::max('pengajar_id')+1;
    $pengajar = new pengajar;
    $pengajar->pengajar_id = $pengajar_id;
    $pengajar->admin_id = $data->admin_id;
    $pengajar->kelas_id = $data->kelas_id;
    $pengajar->mapel_id = $data->mapel_id;
    $pengajar->tgl_daftar = $data->tgl_daftar;
    $pengajar->expired = $data->expired;
    $pengajar->status = $data->status;
    $pengajar->save();
    return ['update' => $pengajar, 'pengajar' => $this->pengajar($data)['pengajar']];
  }
  function update(Request $data){
    $pengajar = pengajar::where('pengajar_id', $data->pengajar_id)->first();
    $pengajar->admin_id = $data->admin_id;
    $pengajar->kelas_id = $data->kelas_id;
    $pengajar->mapel_id = $data->mapel_id;
    $pengajar->tgl_daftar = $data->tgl_daftar;
    $pengajar->expired = $data->expired;
    $pengajar->status = $data->status ?? 0;
    $pengajar->save();
    return ['update' => $pengajar, 'pengajar' => $this->pengajar($data)['pengajar']];
  }
  function delete(Request $data){
    $pengajar = pengajar::where('pengajar_id', $data->pengajar_id)->first();
    $admin = admin::where('pengajar_id', $data->pengajar_id)->update(['pengajar_id'=> null]);
    $pengajar->delete();
    return ['update' => $pengajar, 'pengajar' => $this->pengajar($data)['pengajar']];
  }
}
