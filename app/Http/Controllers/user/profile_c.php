<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\siswa;

class profile_c extends Controller
{
  function profile ($siswa_id) {
    $siswa = siswa::where('siswa_id', $siswa_id)->first();
    $siswa->kelas;
    return $siswa;
  }
}
