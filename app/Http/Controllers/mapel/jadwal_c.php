<?php

namespace App\Http\Controllers\mapel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\jadwal;

class jadwal_c extends Controller
{
  function jadwal(Request $data){
    return "OK";
    $page = jadwal::orderBy('kelas_id', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $jadwal = $page->map(function($i){
      $i->admin;
      $i->kelas;
      $i->mapel;
      return $i;
    });
    return compact('jadwal', 'page');
  }
  function jadwal_select(Request $data){
    $jadwal = jadwal::orderBy('kelas_id', 'DESC');
    if ($data->q) { $jadwal = $jadwal->where('nama', 'like', '%'.$data->q.'%'); }
    $jadwal = $jadwal->paginate(10)->map(function($i){
      $x['id'] = $i->jadwal_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $jadwal;
  }
  function store(Request $data){
    $jadwal_id = jadwal::max('jadwal_id')+1;
    $jadwal = new jadwal;
    $jadwal->jadwal_id = $jadwal_id;
    $jadwal->admin_id = $data->admin_id;
    $jadwal->kelas_id = $data->kelas_id;
    $jadwal->mapel_id = $data->mapel_id;
    $jadwal->tgl_daftar = $data->tgl_daftar;
    $jadwal->expired = $data->expired;
    $jadwal->status = $data->status;
    $jadwal->save();
    return ['update' => $jadwal, 'jadwal' => $this->jadwal($data)['jadwal']];
  }
  function update(Request $data){
    $jadwal = jadwal::where('jadwal_id', $data->jadwal_id)->first();
    $jadwal->admin_id = $data->admin_id;
    $jadwal->kelas_id = $data->kelas_id;
    $jadwal->mapel_id = $data->mapel_id;
    $jadwal->tgl_daftar = $data->tgl_daftar;
    $jadwal->expired = $data->expired;
    $jadwal->status = $data->status ?? 0;
    $jadwal->save();
    return ['update' => $jadwal, 'jadwal' => $this->jadwal($data)['jadwal']];
  }
  function delete(Request $data){
    $jadwal = jadwal::where('jadwal_id', $data->jadwal_id)->first();
    $admin = admin::where('jadwal_id', $data->jadwal_id)->update(['jadwal_id'=> null]);
    $jadwal->delete();
    return ['update' => $jadwal, 'jadwal' => $this->jadwal($data)['jadwal']];
  }
}
