<?php

namespace App\Http\Controllers\keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\keuangan_setting as setting;

class setting_c extends Controller
{
  // SETTING
  function setting(){
    return setting::first();
  }
  function setting_update(Request $data){
    $setting = setting::first() ?? new setting;
    $setting->spp = str_replace('.','',$data->spp ?? 0) ?? null;
    $setting->bangunan = str_replace('.','',$data->bangunan ?? 0) ?? null;
    $setting->seragam = str_replace('.','',$data->seragam ?? 0) ?? null;
    $setting->kesiswaan = str_replace('.','',$data->kesiswaan ?? 0) ?? null;
    $setting->daftar_ulang = str_replace('.','',$data->daftar_ulang ?? 0) ?? null;
    $setting->ppdb = str_replace('.','',$data->ppdb ?? 0) ?? null;
    $setting->save();
    return $setting;
  }
}
