<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Closure;
use Session;
use App\Admin;
use Auth;

class auth_c extends Controller
{
  function auth(){
    return auth::guard('admin-api')->check() ? 1 : 0;
  }
  function check_username(Request $data){
    $check = admin::where('username', $data->username);
    if ($data->except) {
      $check->where('username', '!=', $data->except);
    }
    return $check->count();
  }
  function login(Request $data) {
    $credential = ['username' => $data->username, 'password' => $data->password];
    Auth::guard('admin')->attempt($credential);
    return Auth::guard('admin')->user();
  }
  function logout(Request $data) {
    auth::guard('admin')->logout();
    return redirect('/');
  }
}
