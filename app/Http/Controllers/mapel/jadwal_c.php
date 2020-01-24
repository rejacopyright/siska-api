<?php

namespace App\Http\Controllers\mapel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\carbon;
use App\jadwal;
use App\hari;
use App\kelas;
use App\pengajar;

class jadwal_c extends Controller
{
  function jadwal(Request $data){
    $firstDay = hari::whereNull('libur')->orderBy('hari_id')->first();
    $firstKelas = kelas::orderBy('kelas_id')->first();
    $page = jadwal::orderBy('start');
    if ($data->hari_id) { $page->where('hari_id', $data->hari_id); }else { $page->where('hari_id', $firstDay->hari_id); }
    if ($data->kelas_id) { $page->where('kelas_id', $data->kelas_id); }else { $page->where('kelas_id', $firstKelas->kelas_id); }
    if ($data->q) { $page->where('nama', 'like', '%'.$data->q.'%'); }
    $jadwal = $page->get()->map(function($i) use($data, $firstKelas){
      $pengajar = pengajar::where('kelas_id', ($data->kelas_id ?? $firstKelas->kelas_id))->where('mapel_id', $i->mapel_id)->first();
      $i['kelas'] = $i->kelas;
      $i['hari'] = $i->hari;
      $i['mapel'] = $i->mapel;
      $i['pengajar'] = $pengajar ? $pengajar->admin : null;
      return $i;
    });
    $hari = hari::orderBy('hari_id')->get();
    return compact('jadwal', 'hari', 'firstDay', 'firstKelas');
  }
  function jadwal_select(Request $data){
    $jadwal = jadwal::orderBy('start');
    if ($data->q) { $jadwal = $jadwal->where('nama', 'like', '%'.$data->q.'%'); }
    $jadwal = $jadwal->paginate(10)->map(function($i){
      $x['id'] = $i->jadwal_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $jadwal;
  }
  function jadwal_check(Request $data){
    $jadwal = jadwal::where('kelas_id', $data->kelas_id)->where('hari_id', $data->hari_id)->orderBy('end', 'DESC')->first();
    return $jadwal;
  }
  function store(Request $data){
    $jadwal_id = jadwal::max('jadwal_id')+1;
    $jadwal = new jadwal;
    $jadwal->jadwal_id = $jadwal_id;
    $jadwal->kelas_id = $data->kelas_id;
    $jadwal->hari_id = $data->hari_id;
    $jadwal->mapel_id = $data->mapel_id ?? null;
    $jadwal->start = $data->start;
    $jadwal->end = $data->end;
    $jadwal->save();
    return ['update' => $jadwal, 'jadwal' => $this->jadwal($data)['jadwal']];
  }
  function update(Request $data){
    $jadwal = jadwal::where('jadwal_id', $data->jadwal_id)->first();
    $jadwal->mapel_id = $data->mapel_id;
    $jadwal->save();
    return ['update' => $jadwal, 'jadwal' => $this->jadwal($data)['jadwal']];
  }
  function update_start(Request $data){
    $jadwal = jadwal::where('jadwal_id', $data->jadwal_id)->first();
    $start = new carbon($jadwal->start);
    $end = new carbon($data->start);
    $interval = $start->diffInMinutes($end);
    $time = jadwal::where('kelas_id', $jadwal->kelas_id)->where('hari_id', $jadwal->hari_id)->whereTime('end', '<=', $jadwal->start)->orderBy('start')->get();
    if ($start->lessThan($end)) {
      foreach ($time as $tm) {
        $tm->start = (new carbon($tm->start))->addMinutes($interval);
        $tm->end = (new carbon($tm->end))->addMinutes($interval);
        $tm->save();
      }
    }else if ($start->greaterThan($end)) {
      foreach ($time as $tm) {
        $tm->start = (new carbon($tm->start))->subMinutes($interval);
        $tm->end = (new carbon($tm->end))->subMinutes($interval);
        $tm->save();
      }
    }
    $jadwal->start = $data->start;
    $jadwal->save();
    // return ($time);
    return ['jadwal' => $this->jadwal($data)['jadwal']];
  }
  function update_end(Request $data){
    $jadwal = jadwal::where('jadwal_id', $data->jadwal_id)->first();
    $start = new carbon($jadwal->end);
    $end = new carbon($data->end);
    $interval = $start->diffInMinutes($end);
    $time = jadwal::where('kelas_id', $jadwal->kelas_id)->where('hari_id', $jadwal->hari_id)->where('jadwal_id', '!=', $data->jadwal_id)->whereTime('start', '>=', $jadwal->end)->orderBy('start')->get();
    if ($start->lessThan($end) && $interval) {
      foreach ($time as $tm) {
        $tm->start = (new carbon($tm->start))->addMinutes($interval);
        $tm->end = (new carbon($tm->end))->addMinutes($interval);
        $tm->save();
      }
    }else if ($start->greaterThan($end)) {
      foreach ($time as $tm) {
        $tm->start = (new carbon($tm->start))->subMinutes($interval);
        $tm->end = (new carbon($tm->end))->subMinutes($interval);
        $tm->save();
      }
    }
    $jadwal->end = $data->end;
    $jadwal->save();
    return ['jadwal' => $this->jadwal($data)['jadwal']];
  }
  function delete(Request $data){
    $jadwal = jadwal::where('jadwal_id', $data->jadwal_id)->first();
    $start = new carbon($jadwal->start);
    $end = new carbon($jadwal->end);
    $interval = $start->diffInMinutes($end);
    $time = jadwal::where('kelas_id', $jadwal->kelas_id)->where('hari_id', $jadwal->hari_id)->whereTime('start', '>=', $jadwal->end)->orderBy('start')->get();
    foreach ($time as $tm) {
      $tm->start = (new carbon($tm->start))->subMinutes($interval);
      $tm->end = (new carbon($tm->end))->subMinutes($interval);
      $tm->save();
    }
    // return ($time);
    $jadwal->delete();
    return ['jadwal' => $this->jadwal($data)['jadwal']];
  }
}
