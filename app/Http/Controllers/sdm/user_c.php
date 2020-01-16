<?php

namespace App\Http\Controllers\sdm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Str;
use Image;
use Carbon\Carbon;
use App\Admin as user;

class user_c extends Controller
{
  function user(Request $data){
    $page = user::orderBy('updated_at', 'DESC');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('updated_at', 'DESC')->paginate(10);
    $user = $page->map(function($i){
      $i->jabatan;
      return $i;
    });
    return compact('user', 'page');
  }
  function user_select(Request $data){
    $user = user::orderBy('updated_at', 'DESC');
    if ($data->q) { $user = $user->where('nama', 'like', '%'.$data->q.'%'); }
    $user = $user->paginate(10)->map(function($i){
      $x['id'] = $i->admin_id;
      if ($i->jabatan()->count()) {
        $nama = $i->nama.' ('.$i->jabatan->nama.')';
      }else {
        $nama = $i->nama;
      }
      $x['text'] = $nama;
      return $x;
    });
    return $user;
  }
  function store(Request $data){
    $exist = user::where('username', $data->username)->count();
    $admin_id = user::max('admin_id')+1;
    $user = new user;
    $user->admin_id = $admin_id;
    $user->jabatan_id = $data->jabatan_id;
    $user->username = $data->username;
    $user->password = Hash::make($data->password);
    $user->api_token = Str::random(80);
    $user->nama = $data->nama;
    $user->nip = $data->nip;
    $user->nik = $data->nik;
    $user->kk = $data->kk;
    $user->lahir = new Carbon($data->lahir);
    $user->alamat = $data->alamat;
    $user->gender = $data->gender;
    $user->tlp = $data->tlp;
    $user->wa = $data->wa;
    $user->email = $data->email;
    $user->rek_bank = $data->rek_bank;
    $user->rek_no = $data->rek_no;
    $user->rek_nama = $data->rek_nama;
    $user->tgl = now();
    $user->tgl_daftar = $data->tgl_daftar;
    $user->expired = $data->expired;
    $user->status = 1;
    if (!$exist) {
      $user->save();
    }
    return ['update' => $user, 'user' => $this->user($data)['user']];
  }
  function update(Request $data){
    $user = user::where('admin_id', $data->admin_id)->first();
    $exist = user::where('username', $data->username)->where('username', '!=', $user->username)->count();
    if ($data->jabatan_id) { $user->jabatan_id = $data->jabatan_id; }
    if ($data->username && !$exist) { $user->username = $data->username; }
    if ($data->password) { $user->password = Hash::make($data->password); }
    if ($data->nama) { $user->nama = $data->nama; }
    if ($data->nip) { $user->nip = $data->nip; }
    if ($data->nik) { $user->nik = $data->nik; }
    if ($data->kk) { $user->kk = $data->kk; }
    if ($data->lahir) { $user->lahir = new Carbon($data->lahir); }
    if ($data->alamat) { $user->alamat = $data->alamat; }
    if (isset($data->gender)) { $user->gender = $data->gender; }
    if ($data->tlp) { $user->tlp = $data->tlp; }
    if ($data->wa) { $user->wa = $data->wa; }
    if ($data->email) { $user->email = $data->email; }
    if ($data->rek_bank) { $user->rek_bank = $data->rek_bank; }
    if ($data->rek_no) { $user->rek_no = $data->rek_no; }
    if ($data->rek_nama) { $user->rek_nama = $data->rek_nama; }
    if ($data->tgl_daftar) { $user->tgl_daftar = $data->tgl_daftar; }
    if ($data->expired) { $user->expired = $data->expired; }
    $user->save();
    return ['update' => $user, 'user' => $this->user($data)['user']];
  }
  function update_img(Request $data){
    if ($data->avatar) {
      // $avatar = base64_decode($data->avatar);
      $filename = $data->admin_id.'.jpg';
      if (!is_dir('public/img/user')) { mkdir('public/img/user', 0777, true); }
      if (!is_dir('public/img/user/thumb')) { mkdir('public/img/user/thumb', 0777, true); }
      Image::make($data->avatar)->fit(300)->save('public/img/user/'.$filename, 50);
      Image::make($data->avatar)->fit(100)->save('public/img/user/thumb/'.$filename, 50);
      // STORE DB
      $user = user::where('admin_id', $data->admin_id)->first();
      $user->avatar = $filename;
      $user->save();
    }
    return ['update' => $user, 'user' => $this->user($data)['user']];
  }
}
