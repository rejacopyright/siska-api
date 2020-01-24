<?php

namespace App\Http\Controllers\kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kelas;
use App\Admin as admin;

class kelas_c extends Controller
{
  function kelas(Request $data){
    $page = kelas::orderBy('nama');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $kelas = $page->map(function($i){
      $i->wali_kelas;
      return $i;
    });
    return compact('kelas', 'page');
  }
  function kelas_detail($kelas_id){
    $kelas = kelas::where('kelas_id', $kelas_id)->first();
    return compact('kelas');
  }
  function kelas_select(Request $data){
    $kelas = kelas::orderBy('nama');
    if ($data->q) { $kelas = $kelas->where('nama', 'like', '%'.$data->q.'%'); }
    $kelas = $kelas->paginate(10)->map(function($i){
      $x['id'] = $i->kelas_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $kelas;
  }
  function store(Request $data){
    $exist = kelas::where('nama', $data->nama)->count();
    $kelas_id = kelas::max('kelas_id')+1;
    $kelas = new kelas;
    $kelas->kelas_id = $kelas_id;
    $kelas->wali = $data->wali;
    $kelas->nama = $data->nama;
    if (!$exist) {
      $kelas->save();
    }
    return ['update' => $kelas, 'kelas' => $this->kelas($data)['kelas']];
  }
  function update(Request $data){
    $kelas = kelas::where('kelas_id', $data->kelas_id)->first();
    $exist = kelas::where('nama', $data->nama)->where('nama', '!=', $kelas->nama)->count();
    if ($data->wali) { $kelas->wali = $data->wali; }
    if ($data->nama && !$exist) { $kelas->nama = $data->nama; }
    $kelas->save();
    return ['update' => $kelas, 'kelas' => $this->kelas($data)['kelas']];
  }
  function delete(Request $data){
    $kelas = kelas::where('kelas_id', $data->kelas_id)->first();
    $admin = admin::where('kelas_id', $data->kelas_id)->update(['kelas_id'=> null]);
    $kelas->delete();
    return ['update' => $kelas, 'kelas' => $this->kelas($data)['kelas']];
  }
}
