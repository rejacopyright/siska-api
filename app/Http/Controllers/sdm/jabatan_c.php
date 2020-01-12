<?php

namespace App\Http\Controllers\sdm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\sdm_jabatan as jabatan;
use App\Admin as admin;

class jabatan_c extends Controller
{
  function jabatan(Request $data){
    $page = jabatan::orderBy('updated_at', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('updated_at', 'DESC')->paginate(10);
    $jabatan = $page->map(function($i){
      return $i;
    });
    return compact('jabatan', 'page');
  }
  function jabatan_select(Request $data){
    $jabatan = jabatan::orderBy('updated_at', 'DESC');
    if ($data->q) { $jabatan = $jabatan->where('nama', 'like', '%'.$data->q.'%'); }
    $jabatan = $jabatan->paginate(10)->map(function($i){
      $x['id'] = $i->jabatan_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $jabatan;
  }
  function store(Request $data){
    $exist = jabatan::where('nama', $data->nama)->count();
    $jabatan_id = jabatan::max('jabatan_id')+1;
    $jabatan = new jabatan;
    $jabatan->jabatan_id = $jabatan_id;
    $jabatan->nama = $data->nama;
    if (!$exist) {
      $jabatan->save();
    }
    return ['update' => $jabatan, 'jabatan' => $this->jabatan($data)['jabatan']];
  }
  function update(Request $data){
    $exist = jabatan::where('nama', $data->nama)->count();
    $jabatan = jabatan::where('jabatan_id', $data->jabatan_id)->first();
    $jabatan->nama = $data->nama;
    if (!$exist) {
      $jabatan->save();
    }
    return ['update' => $jabatan, 'jabatan' => $this->jabatan($data)['jabatan']];
  }
  function delete(Request $data){
    $jabatan = jabatan::where('jabatan_id', $data->jabatan_id)->first();
    $admin = admin::where('jabatan_id', $data->jabatan_id)->update(['jabatan_id'=> null]);
    $jabatan->delete();
    return ['update' => $jabatan, 'jabatan' => $this->jabatan($data)['jabatan']];
  }
}
