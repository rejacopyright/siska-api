<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Str;
use Image;
use Storage;
use Carbon\carbon;
use App\siswa;

class siswa_c extends Controller
{
  function nis(){
    $siswa_id = siswa::max('siswa_id')+1;
    $nis = 'S'.str_pad($siswa_id, '10', '0', STR_PAD_LEFT);
    return $nis;
  }
  function detail($siswa_id){
    $siswa = siswa::where('siswa_id', $siswa_id)->first();
    $siswa->kelas;
    return $siswa;
  }
  function siswa(Request $data){
    $page = siswa::whereIn('status', [0,1,4])->orderBy('created_at', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('created_at', 'DESC')->paginate(10);
    $siswa = $page->map(function($i){
      return $i;
    });
    return compact('siswa', 'page');
  }
  function siswa_select(Request $data){
    $siswa = siswa::orderBy('nis', 'DESC');
    if ($data->q) { $siswa = $siswa->where('nis', 'like', '%'.$data->q.'%')->orWhere('nama', 'like', '%'.$data->q.'%'); }
    $siswa = $siswa->paginate(10)->map(function($i){
      $x['id'] = $i->siswa_id;
      $x['text'] = strtoupper($i->nis).' ('.ucwords(strtolower($i->nama)).')';
      return $x;
    });
    return $siswa;
  }
  function alumni(Request $data){
    $page = siswa::where('status', 2)->orderBy('created_at', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('created_at', 'DESC')->paginate(10);
    $siswa = $page->map(function($i){
      return $i;
    });
    return compact('siswa', 'page');
  }
  function daftar(Request $data){
    $page = siswa::where('status', 3)->orderBy('created_at', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('created_at', 'DESC')->paginate(10);
    $siswa = $page->map(function($i){
      return $i;
    });
    return compact('siswa', 'page');
  }
  function store(Request $data){
    $siswa_id = siswa::max('siswa_id')+1;
    if ($data->avatar) {
      $filename = $siswa_id.'.jpg';
      if (!is_dir('public/img/siswa')) { mkdir('public/img/siswa', 0777, true); }
      if (!is_dir('public/img/siswa/thumb')) { mkdir('public/img/siswa/thumb', 0777, true); }
      Image::make($data->avatar)->fit(300)->save('public/img/siswa/'.$filename, 50);
      Image::make($data->avatar)->fit(100)->save('public/img/siswa/thumb/'.$filename, 50);
    }
    $siswa = new siswa;
    $siswa->siswa_id = $siswa_id;
    $siswa->nis = 'S'.str_pad($siswa_id, '10', '0', STR_PAD_LEFT);
    $siswa->password = Hash::make('0000');
    $siswa->api_token = Str::random(80);
    $siswa->nama = $data->nama;
    $siswa->kk = $data->kk;
    $siswa->lahir = new Carbon($data->lahir);
    $siswa->alamat = $data->alamat;
    $siswa->gender = $data->gender;
    $siswa->wali_status = $data->wali_status;
    $siswa->wali_nama = $data->wali_nama;
    $siswa->wali_tlp = $data->wali_tlp;
    $siswa->wali_email = $data->wali_email;
    $siswa->catatan = $data->catatan;
    if ($data->avatar) { $siswa->avatar = $filename; }
    if ($data->kelas_id) { $siswa->kelas_id = $data->kelas_id; }
    $siswa->status = $data->status ?? 0;
    $siswa->save();
    $siswa->kelas;
    return ['update' => $siswa, 'siswa' => $this->aktif($data)['siswa']];
  }
  function update(Request $data){
    $siswa = siswa::where('siswa_id', $data->siswa_id)->first();
    if ($data->avatar == 'delete' && Storage::disk('local')->exists('public/img/siswa/'.$siswa->avatar)) {
      Storage::delete('public/img/siswa/'.$siswa->avatar);
      Storage::delete('public/img/siswa/thumb/'.$siswa->avatar);
      $siswa->avatar = null;
    }elseif ($data->avatar) {
      $filename = $siswa->siswa_id.'.jpg';
      if (!is_dir('public/img/siswa')) { mkdir('public/img/siswa', 0777, true); }
      if (!is_dir('public/img/siswa/thumb')) { mkdir('public/img/siswa/thumb', 0777, true); }
      Image::make($data->avatar)->fit(300)->save('public/img/siswa/'.$filename, 50);
      Image::make($data->avatar)->fit(100)->save('public/img/siswa/thumb/'.$filename, 50);
      $siswa->avatar = $filename;
    }
    if ($data->nama) { $siswa->nama = $data->nama; }
    if ($data->kk) { $siswa->kk = $data->kk; }
    if ($data->lahir) { $siswa->lahir = new Carbon($data->lahir); }
    if ($data->alamat) { $siswa->alamat = $data->alamat; }
    $siswa->gender = $data->gender;
    if ($data->wali_status) { $siswa->wali_status = $data->wali_status; }
    if ($data->wali_nama) { $siswa->wali_nama = $data->wali_nama; }
    if ($data->wali_tlp) { $siswa->wali_tlp = $data->wali_tlp; }
    if ($data->wali_email) { $siswa->wali_email = $data->wali_email; }
    if ($data->catatan) { $siswa->catatan = $data->catatan; }
    if (!empty($data->password)) { $siswa->password = Hash::make($data->password); }
    if ($data->kelas_id) { $siswa->kelas_id = $data->kelas_id; }
    $siswa->status = $data->status ?? 0;
    $siswa->save();
    $siswa->kelas;
    return ['update' => $siswa, 'siswa' => $this->siswa($data)['siswa']];
  }
}
