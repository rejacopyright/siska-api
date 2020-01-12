<?php

namespace App\Http\Controllers\semester;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\semester;
use App\Admin as admin;

class semester_c extends Controller
{
  function semester(Request $data){
    $page = semester::orderBy('nama');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $semester = $page->map(function($i){
      $i->wali_semester;
      return $i;
    });
    return compact('semester', 'page');
  }
  function semester_select(Request $data){
    $semester = semester::orderBy('updated_at', 'DESC');
    if ($data->q) { $semester = $semester->where('nama', 'like', '%'.$data->q.'%'); }
    $semester = $semester->paginate(10)->map(function($i){
      $x['id'] = $i->semester_id;
      $x['text'] = ucwords(strtolower($i->nama));
      return $x;
    });
    return $semester;
  }
  function store(Request $data){
    $exist = semester::where('nama', $data->nama)->count();
    $semester_id = semester::max('semester_id')+1;
    $semester = new semester;
    $semester->semester_id = $semester_id;
    $semester->nama = $data->nama;
    $semester->dari = $data->dari;
    $semester->sampai = $data->sampai;
    if (!$exist) {
      $semester->save();
    }
    return ['update' => $semester, 'semester' => $this->semester($data)['semester']];
  }
  function update(Request $data){
    $exist = semester::where('nama', $data->nama)->count();
    $semester = semester::where('semester_id', $data->semester_id)->first();
    if ($data->nama && !$exist) { $semester->nama = $data->nama; }
    if ($data->dari) { $semester->dari = $data->dari; }
    if ($data->sampai) { $semester->sampai = $data->sampai; }
    $semester->save();
    return ['update' => $semester, 'semester' => $this->semester($data)['semester']];
  }
  function delete(Request $data){
    $semester = semester::where('semester_id', $data->semester_id)->first();
    $admin = admin::where('semester_id', $data->semester_id)->update(['semester_id'=> null]);
    $semester->delete();
    return ['update' => $semester, 'semester' => $this->semester($data)['semester']];
  }
}
