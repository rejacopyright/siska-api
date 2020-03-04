<?php

namespace App\Http\Controllers\perpustakaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Carbon\carbon;
use App\perpustakaan_kategori as kategori;
use App\perpustakaan_koleksi as koleksi;
use App\perpustakaan_penerbit as penerbit;
use App\perpustakaan_pinjam as pinjam;
use App\perpustakaan_setting as setting;
use App\perpustakaan;
use App\siswa;

class perpustakaan_c extends Controller
{
  // IMAGE
  function fit($name, $folder, $dimension, $file){
    $filename = $name.'.jpg';
    if (!is_dir($folder)) { mkdir($folder, 0777, true); }
    $width = $height = $dimension;
    $image = Image::make($file);
    $image->width() > $image->height() ? $height=null : $width=null;
    $image->resize($width, $height, function ($c) { $c->aspectRatio();$c->upsize(); })->fill('ffffff', 0, 0)->resizeCanvas($dimension, $dimension);
    $image->save($folder.'/'.$filename, 50);
    return compact('filename');
  }
  // SETTING
  function setting(){
    return setting::first();
  }
  function setting_update(Request $data){
    $setting = setting::first() ?? new setting;
    $setting->harga = str_replace('.','',$data->harga ?? 0) ?? null;
    $setting->durasi = str_replace('.','',$data->durasi ?? 0) ?? null;
    $setting->limit = str_replace('.','',$data->limit ?? 0) ?? null;
    $setting->denda_terlambat = str_replace('.','',$data->denda_terlambat ?? 0) ?? null;
    $setting->denda_rusak = str_replace('.','',$data->denda_rusak ?? 0) ?? null;
    $setting->denda_hilang = str_replace('.','',$data->denda_hilang ?? 0) ?? null;
    $setting->save();
    return $setting;
  }
  // KATEGORI
  function kategori(Request $data){
    $page = kategori::orderBy('nama');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('nama')->paginate(10);
    $kategori = $page->map(function($i){
      return $i;
    });
    return compact('kategori', 'page');
  }
  function kategori_select(Request $data){
    $kategori = kategori::orderBy('nama');
    if ($data->q) { $kategori = $kategori->where('nama', 'like', '%'.$data->q.'%'); }
    $kategori = $kategori->paginate(10)->map(function($i){
      $x['id'] = $i->kategori_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $kategori;
  }
  function kategori_store(Request $data){
    $exist = kategori::where('nama', $data->nama)->count();
    $kategori_id = kategori::max('kategori_id')+1;
    $kategori = new kategori;
    $kategori->kategori_id = $kategori_id;
    $kategori->nama = $data->nama;
    $kategori->keterangan = $data->keterangan;
    if (!$exist) {
      $kategori->save();
    }
    return ['update' => $kategori, 'kategori' => $this->kategori($data)['kategori']];
  }
  function kategori_update(Request $data){
    $kategori = kategori::where('kategori_id', $data->kategori_id)->first();
    $exist = kategori::where('nama', $data->nama)->where('nama', '!=', $kategori->nama)->count();
    if ($data->nama && !$exist) { $kategori->nama = $data->nama; }
    if ($data->keterangan) { $kategori->keterangan = $data->keterangan; }
    $kategori->save();
    return ['update' => $kategori, 'kategori' => $this->kategori($data)['kategori']];
  }
  // KOLEKSI
  function koleksi(Request $data){
    $page = koleksi::orderBy('nama');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('nama')->paginate(10);
    $koleksi = $page->map(function($i){
      return $i;
    });
    return compact('koleksi', 'page');
  }
  function koleksi_select(Request $data){
    $koleksi = koleksi::orderBy('nama');
    if ($data->q) { $koleksi = $koleksi->where('nama', 'like', '%'.$data->q.'%'); }
    $koleksi = $koleksi->paginate(10)->map(function($i){
      $x['id'] = $i->koleksi_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $koleksi;
  }
  function koleksi_store(Request $data){
    $exist = koleksi::where('nama', $data->nama)->count();
    $koleksi_id = koleksi::max('koleksi_id')+1;
    $koleksi = new koleksi;
    $koleksi->koleksi_id = $koleksi_id;
    $koleksi->nama = $data->nama;
    $koleksi->keterangan = $data->keterangan;
    if (!$exist) {
      $koleksi->save();
    }
    return ['update' => $koleksi, 'koleksi' => $this->koleksi($data)['koleksi']];
  }
  function koleksi_update(Request $data){
    $koleksi = koleksi::where('koleksi_id', $data->koleksi_id)->first();
    $exist = koleksi::where('nama', $data->nama)->where('nama', '!=', $koleksi->nama)->count();
    if ($data->nama && !$exist) { $koleksi->nama = $data->nama; }
    if ($data->keterangan) { $koleksi->keterangan = $data->keterangan; }
    $koleksi->save();
    return ['update' => $koleksi, 'koleksi' => $this->koleksi($data)['koleksi']];
  }
  // PENERBIT
  function penerbit(Request $data){
    $page = penerbit::orderBy('nama');
    if ($data->q) {
      $page->where('nama', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('nama')->paginate(10);
    $penerbit = $page->map(function($i){
      return $i;
    });
    return compact('penerbit', 'page');
  }
  function penerbit_select(Request $data){
    $penerbit = penerbit::orderBy('nama');
    if ($data->q) { $penerbit = $penerbit->where('nama', 'like', '%'.$data->q.'%'); }
    $penerbit = $penerbit->paginate(10)->map(function($i){
      $x['id'] = $i->penerbit_id;
      $x['text'] = $i->nama;
      return $x;
    });
    return $penerbit;
  }
  function penerbit_store(Request $data){
    $exist = penerbit::where('nama', $data->nama)->count();
    $penerbit_id = penerbit::max('penerbit_id')+1;
    $penerbit = new penerbit;
    $penerbit->penerbit_id = $penerbit_id;
    $penerbit->nama = $data->nama;
    $penerbit->tlp = $data->tlp;
    $penerbit->alamat = $data->alamat;
    $penerbit->keterangan = $data->keterangan;
    if (!$exist) {
      $penerbit->save();
    }
    return ['update' => $penerbit, 'penerbit' => $this->penerbit($data)['penerbit']];
  }
  function penerbit_update(Request $data){
    $penerbit = penerbit::where('penerbit_id', $data->penerbit_id)->first();
    $exist = penerbit::where('nama', $data->nama)->where('nama', '!=', $penerbit->nama)->count();
    if ($data->nama && !$exist) { $penerbit->nama = $data->nama; }
    if ($data->tlp) { $penerbit->tlp = $data->tlp; }
    if ($data->alamat) { $penerbit->alamat = $data->alamat; }
    if ($data->keterangan) { $penerbit->keterangan = $data->keterangan; }
    $penerbit->save();
    return ['update' => $penerbit, 'penerbit' => $this->penerbit($data)['penerbit']];
  }
  // PERPUSTAKAAN
  function perpustakaan(Request $data){
    $page = perpustakaan::orderBy('judul');
    if ($data->q) {
      $page->where('judul', 'like', '%'.$data->q.'%');
    }
    $page = $page->orderBy('judul')->paginate(10);
    $perpustakaan = $page->map(function($i){
      $i->kategori;
      $i->koleksi;
      $i->penerbit;
      return $i;
    });
    return compact('perpustakaan', 'page');
  }
  function perpustakaan_select(Request $data){
    $perpustakaan = perpustakaan::orderBy('judul');
    if ($data->q) { $perpustakaan = $perpustakaan->where('judul', 'like', '%'.$data->q.'%'); }
    $perpustakaan = $perpustakaan->paginate(10)->map(function($i){
      $x['id'] = $i->perpustakaan_id;
      $x['text'] = $i->judul;
      return $x;
    });
    return $perpustakaan;
  }
  function perpustakaan_store(Request $data){
    $perpustakaan_id = perpustakaan::max('perpustakaan_id')+1;
    $perpustakaan = new perpustakaan;
    $perpustakaan->perpustakaan_id = $perpustakaan_id;
    $perpustakaan->kategori_id = $data->kategori_id;
    $perpustakaan->koleksi_id = $data->koleksi_id;
    $perpustakaan->penerbit_id = $data->penerbit_id;
    $perpustakaan->judul = $data->judul;
    $perpustakaan->keterangan = $data->keterangan;
    $perpustakaan->bahasa = $data->bahasa;
    $perpustakaan->pengarang = $data->pengarang;
    $perpustakaan->tahun = $data->tahun;
    $perpustakaan->sumber = $data->sumber;
    $perpustakaan->stok = $data->stok;
    $perpustakaan->status = 1;
    $perpustakaan->save();
    return ['update' => $perpustakaan, 'perpustakaan' => $this->perpustakaan($data)['perpustakaan']];
  }
  function perpustakaan_update(Request $data){
    $perpustakaan = perpustakaan::where('perpustakaan_id', $data->perpustakaan_id)->first();
    if ($data->kategori_id) { $perpustakaan->kategori_id = $data->kategori_id; }
    if ($data->koleksi_id) { $perpustakaan->koleksi_id = $data->koleksi_id; }
    if ($data->penerbit_id) { $perpustakaan->penerbit_id = $data->penerbit_id; }
    if ($data->judul) { $perpustakaan->judul = $data->judul; }
    if ($data->keterangan) { $perpustakaan->keterangan = $data->keterangan; }
    if ($data->bahasa) { $perpustakaan->bahasa = $data->bahasa; }
    if ($data->pengarang) { $perpustakaan->pengarang = $data->pengarang; }
    if ($data->tahun) { $perpustakaan->tahun = $data->tahun; }
    if ($data->sumber) { $perpustakaan->sumber = $data->sumber; }
    if ($data->stok) { $perpustakaan->stok = $data->stok; }
    $perpustakaan->save();
    return ['update' => $perpustakaan, 'perpustakaan' => $this->perpustakaan($data)['perpustakaan']];
  }
  function perpustakaan_update_img(Request $data){
    if ($data->img) {
      $img = $this->fit($data->perpustakaan_id, 'public/img/book', 350, $data->img);
      $this->fit($data->perpustakaan_id, 'public/img/book/thumb', 100, $data->img);
      // STORE DB
      $perpustakaan = perpustakaan::where('perpustakaan_id', $data->perpustakaan_id)->first();
      $perpustakaan->img = $img['filename'];
      $perpustakaan->save();
    }
    return ['update' => $perpustakaan, 'perpustakaan' => $this->perpustakaan($data)['perpustakaan']];
  }
  // PERPUSTAKAAN
  function perpustakaan_pinjam(Request $data){
    $page = pinjam::orderBy('created_at', 'DESC');
    $siswa_id = siswa::where('nis', 'like', '%'.$data->q.'%')->orWhere('nama', 'like', '%'.$data->q.'%')->select('siswa_id')->pluck('siswa_id')->all();
    $perpustakaan_id = perpustakaan::where('judul', 'like', '%'.$data->q.'%')->select('perpustakaan_id')->pluck('perpustakaan_id')->all();
    if ($data->q) {
      $page->whereIn('siswa_id', $siswa_id)->orWhere(function($query) use ($perpustakaan_id){
        $query->whereIn('perpustakaan_id', $perpustakaan_id);
      });
    }
    $page = $page->orderBy('created_at', 'DESC')->paginate(10);
    $pinjam = $page->map(function($i){
      $i->siswa;
      $i->buku;
      $i['durasi'] = setting::first()->durasi ?? null;
      return $i;
    });
    return compact('pinjam', 'page');
  }
  function perpustakaan_pinjam_store(Request $data){
    $setting = setting::first();
    $pinjam_id = pinjam::max('pinjam_id')+1;
    $pinjam = new pinjam;
    $pinjam->pinjam_id = $pinjam_id;
    $pinjam->siswa_id = $data->siswa_id;
    $pinjam->perpustakaan_id = $data->perpustakaan_id;
    $pinjam->keterangan = $data->keterangan;
    $pinjam->tgl_pinjam = now();
    $pinjam->tgl_dikembalikan = (new carbon())->addDays(($setting->durasi ?? 1));
    $pinjam->status = 2;
    $pinjam->save();
    return ['update' => $pinjam, 'pinjam' => $this->perpustakaan_pinjam($data)['pinjam']];
  }
  function perpustakaan_pinjam_update(Request $data){
    $setting = setting::first();
    $pinjam = pinjam::where('pinjam_id', $data->pinjam_id)->first();
    if ($data->siswa_id) { $pinjam->siswa_id = $data->siswa_id; }
    if ($data->perpustakaan_id) { $pinjam->perpustakaan_id = $data->perpustakaan_id; }
    $pinjam->keterangan = $data->keterangan;
    $pinjam->status = $data->status ?? $pinjam->status;
    $pinjam->save();
    return ['update' => $pinjam, 'pinjam' => $this->perpustakaan_pinjam($data)['pinjam']];
  }
  function perpustakaan_pinjam_extend(Request $data){
    $pinjam = pinjam::where('pinjam_id', $data->pinjam_id)->first();
    $extend = new Carbon($data->tgl_dikembalikan);
    if ($extend->isAfter($pinjam->tgl_dikembalikan)) {
      $pinjam->tgl_dikembalikan = $data->tgl_dikembalikan;
      $pinjam->status = 6;
      $pinjam->save();
    }
    return ['update' => $pinjam, 'pinjam' => $this->perpustakaan_pinjam($data)['pinjam']];
  }
  function perpustakaan_pinjam_extend_undo(Request $data){
    $pinjam = pinjam::where('pinjam_id', $data->pinjam_id)->first();
    $extend = new Carbon($data->tgl_dikembalikan);
    $pinjam->tgl_dikembalikan = $data->tgl_dikembalikan;
    $pinjam->status = 2;
    $pinjam->save();
    return ['update' => $pinjam, 'pinjam' => $this->perpustakaan_pinjam($data)['pinjam']];
  }
}
