<?php
Route::group(["middleware" => "auth:admin-api"], function(){
  // Kurikulum Kategori
  Route::get('kurikulum/kategori', 'kurikulum\kategori_c@kategori');
  Route::get('kurikulum/kategori/select', 'kurikulum\kategori_c@kategori_select');
  Route::post('kurikulum/kategori/store', 'kurikulum\kategori_c@store');
  Route::post('kurikulum/kategori/update', 'kurikulum\kategori_c@update');
  Route::post('kurikulum/kategori/delete', 'kurikulum\kategori_c@delete');
  // Kurikulum Mapel
  Route::get('kurikulum/mapel', 'kurikulum\mapel_c@mapel');
  Route::get('mapel/test', 'kurikulum\mapel_c@test');
  Route::get('kurikulum/mapel/select', 'kurikulum\mapel_c@mapel_select');
  Route::post('kurikulum/mapel/store', 'kurikulum\mapel_c@store');
  Route::post('kurikulum/mapel/update', 'kurikulum\mapel_c@update');
  Route::post('kurikulum/mapel/delete', 'kurikulum\mapel_c@delete');
  // Kurikulum Silabus
  Route::get('kurikulum/silabus', 'kurikulum\silabus_c@silabus');
  Route::get('kurikulum/silabus/select', 'kurikulum\silabus_c@silabus_select');
  Route::get('kurikulum/silabus/select/{kelas_id}/{semester_id}/{mapel_id}', 'kurikulum\silabus_c@silabus_select_filter');
  Route::post('kurikulum/silabus/store', 'kurikulum\silabus_c@store');
  Route::post('kurikulum/silabus/update', 'kurikulum\silabus_c@update');
  Route::post('kurikulum/silabus/delete', 'kurikulum\silabus_c@delete');
  // Kurikulum RPP
  Route::get('kurikulum/rpp', 'kurikulum\rpp_c@rpp');
  Route::get('kurikulum/rpp/detail/{rpp_id}', 'kurikulum\rpp_c@detail');
  Route::get('kurikulum/rpp/select', 'kurikulum\rpp_c@rpp_select');
  Route::post('kurikulum/rpp/store', 'kurikulum\rpp_c@store');
  Route::post('kurikulum/rpp/update', 'kurikulum\rpp_c@update');
  Route::post('kurikulum/rpp/delete', 'kurikulum\rpp_c@delete');
  // Kurikulum Materi
  Route::get('kurikulum/materi', 'kurikulum\materi_c@materi');
  Route::get('kurikulum/materi/select', 'kurikulum\materi_c@materi_select');
  Route::post('kurikulum/materi/store', 'kurikulum\materi_c@store');
  Route::get('kurikulum/materi/detail/{materi_id}', 'kurikulum\materi_c@detail');
  Route::post('kurikulum/materi/update', 'kurikulum\materi_c@update');
  Route::post('kurikulum/materi/delete', 'kurikulum\materi_c@delete');
  // SDM Jabatan
  Route::get('sdm/jabatan', 'sdm\jabatan_c@jabatan');
  Route::get('sdm/jabatan/select', 'sdm\jabatan_c@jabatan_select');
  Route::post('sdm/jabatan/store', 'sdm\jabatan_c@store');
  Route::post('sdm/jabatan/update', 'sdm\jabatan_c@update');
  Route::post('sdm/jabatan/delete', 'sdm\jabatan_c@delete');
  // SDM User
  Route::get('sdm/user', 'sdm\user_c@user');
  Route::get('sdm/user/select', 'sdm\user_c@user_select');
  Route::post('sdm/user/store', 'sdm\user_c@store');
  Route::post('sdm/user/update', 'sdm\user_c@update');
  Route::post('sdm/user/update_img', 'sdm\user_c@update_img');
  Route::post('sdm/user/delete', 'sdm\user_c@delete');
  // MAPEL Pengajar
  Route::get('pengajar', 'mapel\pengajar_c@pengajar');
  Route::get('pengajar/select', 'mapel\pengajar_c@pengajar_select');
  Route::post('pengajar/store', 'mapel\pengajar_c@store');
  Route::post('pengajar/update', 'mapel\pengajar_c@update');
  Route::post('pengajar/delete', 'mapel\pengajar_c@delete');
  // MAPEL Jadwal
  Route::get('test/jadwal', 'mapel\jadwal_c@jadwal');
  Route::get('test/jadwal/select', 'mapel\jadwal_c@jadwal_select');
  Route::post('test/jadwal/store', 'mapel\jadwal_c@store');
  Route::post('test/jadwal/update', 'mapel\jadwal_c@update');
  Route::post('test/jadwal/delete', 'mapel\jadwal_c@delete');
  // SISWA
  Route::get('siswa/nis', 'siswa\siswa_c@nis');
  Route::get('siswa/detail/{siswa_id}', 'siswa\siswa_c@detail');
  Route::get('siswa', 'siswa\siswa_c@siswa');
  Route::get('siswa/select', 'siswa\siswa_c@siswa_select');
  Route::get('siswa/alumni', 'siswa\siswa_c@alumni');
  Route::get('siswa/daftar', 'siswa\siswa_c@daftar');
  Route::post('siswa/store', 'siswa\siswa_c@store');
  Route::post('siswa/update', 'siswa\siswa_c@update');
  // KELAS
  Route::get('kelas', 'kelas\kelas_c@kelas');
  Route::get('kelas/select', 'kelas\kelas_c@kelas_select');
  Route::post('kelas/store', 'kelas\kelas_c@store');
  Route::post('kelas/update', 'kelas\kelas_c@update');
  Route::post('kelas/delete', 'kelas\kelas_c@delete');
  // SEMESTER
  Route::get('semester', 'semester\semester_c@semester');
  Route::get('semester/select', 'semester\semester_c@semester_select');
  Route::post('semester/store', 'semester\semester_c@store');
  Route::post('semester/update', 'semester\semester_c@update');
  Route::post('semester/delete', 'semester\semester_c@delete');
  // PERPUSTAKAAN
  Route::get('perpustakaan/setting', 'perpustakaan\perpustakaan_c@setting');
  Route::post('perpustakaan/setting/update', 'perpustakaan\perpustakaan_c@setting_update');
  // Kategori
  Route::get('perpustakaan/kategori', 'perpustakaan\perpustakaan_c@kategori');
  Route::get('perpustakaan/kategori/select', 'perpustakaan\perpustakaan_c@kategori_select');
  Route::post('perpustakaan/kategori/store', 'perpustakaan\perpustakaan_c@kategori_store');
  Route::post('perpustakaan/kategori/update', 'perpustakaan\perpustakaan_c@kategori_update');
  // Koleksi
  Route::get('perpustakaan/koleksi', 'perpustakaan\perpustakaan_c@koleksi');
  Route::get('perpustakaan/koleksi/select', 'perpustakaan\perpustakaan_c@koleksi_select');
  Route::post('perpustakaan/koleksi/store', 'perpustakaan\perpustakaan_c@koleksi_store');
  Route::post('perpustakaan/koleksi/update', 'perpustakaan\perpustakaan_c@koleksi_update');
  // Penerbit
  Route::get('perpustakaan/penerbit', 'perpustakaan\perpustakaan_c@penerbit');
  Route::get('perpustakaan/penerbit/select', 'perpustakaan\perpustakaan_c@penerbit_select');
  Route::post('perpustakaan/penerbit/store', 'perpustakaan\perpustakaan_c@penerbit_store');
  Route::post('perpustakaan/penerbit/update', 'perpustakaan\perpustakaan_c@penerbit_update');
  // Buku
  Route::get('perpustakaan', 'perpustakaan\perpustakaan_c@perpustakaan');
  Route::get('perpustakaan/select', 'perpustakaan\perpustakaan_c@perpustakaan_select');
  Route::post('perpustakaan/store', 'perpustakaan\perpustakaan_c@perpustakaan_store');
  Route::post('perpustakaan/update', 'perpustakaan\perpustakaan_c@perpustakaan_update');
  Route::post('perpustakaan/update_img', 'perpustakaan\perpustakaan_c@perpustakaan_update_img');
  // Pinjam
  Route::get('perpustakaan/pinjam', 'perpustakaan\perpustakaan_c@perpustakaan_pinjam');
  Route::post('perpustakaan/pinjam/store', 'perpustakaan\perpustakaan_c@perpustakaan_pinjam_store');
  Route::post('perpustakaan/pinjam/update', 'perpustakaan\perpustakaan_c@perpustakaan_pinjam_update');
  Route::post('perpustakaan/pinjam/extend', 'perpustakaan\perpustakaan_c@perpustakaan_pinjam_extend');
  Route::post('perpustakaan/pinjam/extend/undo', 'perpustakaan\perpustakaan_c@perpustakaan_pinjam_extend_undo');

  Route::get('bulan', 'indonesia_c@bulan');
  Route::get('lokasi', 'indonesia_c@lokasi');
  Route::get('provinsi', 'indonesia_c@provinsi');
  Route::get('admin/check/username', 'admin\auth_c@check_username');
  Route::get('admin/auth', 'admin\auth_c@auth');
});
Route::group(["middleware" => "auth:siswa-api", "prefix" => "siswa"], function(){
  Route::get('profile/{siswa_id}', 'user\profile_c@profile');
  Route::get('materi/{kelas_id}', 'user\materi_c@materi');
  Route::get('kurikulum/mapel/select', 'kurikulum\mapel_c@mapel_select');
  Route::get('lokasi', 'indonesia_c@lokasi');
});
Route::post('admin/login', 'admin\auth_c@login');
Route::get('admin/logout', 'admin\auth_c@logout');
Route::post('siswa/login', 'user\auth_c@login');
Route::get('siswa/logout', 'user\auth_c@logout');
