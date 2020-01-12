<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\indonesia\desa;
use App\indonesia\kecamatan;
use App\indonesia\kota;
use App\indonesia\provinsi;

class indonesia_c extends Controller
{
  function lokasi(Request $data){
    $q = explode(' ', str_replace(',', ' ', $data->q));
    $query = function($item) use($q){
      for ($i=0; $i < count($q); $i++) {
        $item->orWhere('nama', 'like', '%'.$q[$i].'%');
      }
    };
    $limit = 5;
    $result = collect([]);
    $desa = desa::where($query)->take($limit)->get()->map(function($i){
      $i['provinsi'] = ucwords(strtolower($i->kecamatan->kota->provinsi->nama));
      $i['kota'] = ucwords(strtolower($i->kecamatan->kota->nama));
      $i['kecamatan'] = ucwords(strtolower($i->kecamatan->nama));
      $i['desa'] = ucwords(strtolower($i->nama));
      return $i->only('desa', 'kecamatan', 'kota', 'provinsi');
    });
    $kecamatan = kecamatan::where($query)->take($limit)->get()->map(function($i){
      $i['provinsi'] = ucwords(strtolower($i->kota->provinsi->nama));
      $i['kota'] = ucwords(strtolower($i->kota->nama));
      $i['kecamatan'] = ucwords(strtolower($i->nama));
      return $i->only('kecamatan', 'kota', 'provinsi');
    });
    $kota = kota::where($query)->take($limit)->get()->map(function($i){
      $i['provinsi'] = ucwords(strtolower($i->provinsi->nama));
      $i['kota'] = ucwords(strtolower($i->nama));
      return $i->only('kota', 'provinsi');
    });
    $provinsi = provinsi::where($query)->take($limit)->get()->map(function($i){
      $i['provinsi'] = ucwords(strtolower($i->nama));
      return $i->only('provinsi');
    });
    $result = $result->merge($provinsi)->merge($kota)->merge($kecamatan)->merge($desa);
    return $result->take($limit);
  }
  function provinsi(){
    $provinsi = provinsi::paginate(10)->map(function($i){
      $x['id'] = $i->provinsi_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $provinsi;
  }
  function bulan(Request $data){
    return 'bulan';
  }
}
