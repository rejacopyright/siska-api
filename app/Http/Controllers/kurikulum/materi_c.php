<?php

namespace App\Http\Controllers\kurikulum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\materi;
use App\Admin as admin;

class materi_c extends Controller
{
  function materi(Request $data){
    $page = materi::orderBy('updated_at', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $materi = $page->map(function($i){
      $i['kelas'] = $i->rpp->silabus->kelas->nama;
      $i['semester'] = $i->rpp->silabus->semester->nama;
      $i['mapel'] = $i->rpp->silabus->mapel->nama;
      $i['sk'] = $i->rpp->silabus->sk;
      $i['kd'] = $i->rpp->kd;
      return $i;
    });
    return compact('materi', 'page');
  }
  function detail($materi_id){
    $materi = materi::where('materi_id', $materi_id)->first();
    $materi->rpp;
    $materi['silabus'] = $materi->rpp->silabus;
    $materi['kelas'] = $materi->rpp->silabus->kelas->nama;
    $materi['semester'] = $materi->rpp->silabus->semester->nama;
    $materi['mapel'] = $materi->rpp->silabus->mapel->nama;
    return $materi;
  }
  function materi_select(Request $data){
    $materi = materi::orderBy('updated_at', 'DESC');
    if ($data->q) { $materi = $materi->where('nama', 'like', '%'.$data->q.'%'); }
    $materi = $materi->paginate(10)->map(function($i){
      $x['id'] = $i->materi_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $materi;
  }
  function store(Request $data){
    $materi_id = materi::max('materi_id')+1;
    $materi = new materi;
    $materi->materi_id = $materi_id;
    $materi->rpp_id = $data->rpp_id;
    $materi->nama = $data->nama;
    $materi->indikator = $data->indikator;
    $materi->metode = $data->metode;
    $materi->sumber = $data->sumber;
    $materi->kegiatan = $data->kegiatan;
    $materi->save();
    return ['update' => $materi, 'materi' => $this->materi($data)['materi']];
  }
  function update(Request $data){
    $materi = materi::where('materi_id', $data->materi_id)->first();
    if ($data->rpp_id) { $materi->rpp_id = $data->rpp_id; }
    if ($data->nama) { $materi->nama = $data->nama; }
    if ($data->indikator) { $materi->indikator = $data->indikator; }
    if ($data->metode) { $materi->metode = $data->metode; }
    if ($data->sumber) { $materi->sumber = $data->sumber; }
    if ($data->kegiatan) { $materi->kegiatan = $data->kegiatan; }
    if ($data->materi) { $materi->materi = $data->materi; }
    $materi->save();
    return ['update' => $materi, 'materi' => $this->detail($data->materi_id)];
  }
  function delete(Request $data){
    $materi = materi::where('materi_id', $data->materi_id)->first();
    $admin = admin::where('materi_id', $data->materi_id)->update(['materi_id'=> null]);
    $materi->delete();
    return ['update' => $materi, 'materi' => $this->materi($data)['materi']];
  }
}
