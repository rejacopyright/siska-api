<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Closure;
use Session;
use App\siswa;
use Auth;

class auth_c extends Controller
{
  function auth(){
    return auth::guard('siswa-api')->check() ? 1 : 0;
  }
  function check_nis(Request $data){
    $check = siswa::where('nis', $data->nis);
    if ($data->except) {
      $check->where('nis', '!=', $data->except);
    }
    return $check->count();
  }
  function login(Request $data) {
    $credential = ['nis' => $data->nis, 'password' => $data->password];
    Auth::guard('siswa')->attempt($credential);
    return Auth::guard('siswa')->user();
  }
  function logout(Request $data) {
    auth::guard('siswa')->logout();
    return redirect('/');
  }
}
