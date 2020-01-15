<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kurikulum_mapel as mapel;
use App\silabus;
use App\rpp;
use App\materi;
use App\pengajar;
use App\Admin;

class materi_c extends Controller
{
  function materi(Request $data, $kelas_id){
    $mapel_id = pengajar::where('kelas_id', $kelas_id)->distinct('mapel_id')->pluck('mapel_id')->all();
    if ($data->mapel_id) {
      $mapel_id = $data->mapel_id;
    }
    $mapel = mapel::whereIn('mapel_id', $mapel_id)->get();
    $silabus_id = silabus::where('kelas_id', $kelas_id)->whereIn('mapel_id', $mapel_id)->distinct('silabus_id')->pluck('silabus_id')->all();
    $rpp_id = rpp::whereIn('silabus_id', $silabus_id)->distinct('rpp_id')->pluck('rpp_id')->all();
    $page = materi::whereIn('rpp_id', $rpp_id)->orderBy('updated_at', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->paginate(10);
    $materi = $page->map(function($i) use ($kelas_id){
      $i['kelas'] = $i->rpp->silabus->kelas->nama;
      $i['semester'] = $i->rpp->silabus->semester->nama;
      $i['mapel_id'] = $i->rpp->silabus->mapel->mapel_id;
      $i['mapel'] = $i->rpp->silabus->mapel->nama;
      $i['sk'] = $i->rpp->silabus->sk;
      $i['kd'] = $i->rpp->kd;
      $i['pengajar'] = pengajar::where('kelas_id', $kelas_id)->where('mapel_id', $i->rpp->silabus->mapel->mapel_id)->first()->admin;
      return $i;
    });
    return compact('materi', 'page', 'mapel');
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
    $materi->delete();
    return ['update' => $materi, 'materi' => $this->materi($data)['materi']];
  }
}
