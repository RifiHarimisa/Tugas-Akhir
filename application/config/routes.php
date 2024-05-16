<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'LoginUser';

// ADMIN AREA
$route['ubahpassword_admin'] = 'Admin/ubahpassword';
$route['authmin'] = 'LoginAdmin';
$route['authmin_proc'] = 'LoginAdmin/proses_login';
$route['outmin'] = 'Admin/logout';
$route['homemin'] = 'Admin';
$route['cekusername'] = 'Admin/cek_username';

$route['m-lowongan'] = 'Admin/master_lowongan';
$route['min/detail_lowongan'] = 'Admin/detail_lowongan';

$route['m-lamaran'] = 'Admin/lamaran';
$route['cek_lamaran'] = 'Admin/cek_lamaran';
$route['simpan_nilai'] = 'Admin/simpan_nilai';


$route['data-pelamar'] = 'Admin/pelamar';
$route['update_pelamar'] = 'Admin/update_pelamar';

$route['data-perusahaan'] = 'Admin/perusahaan';
$route['update_perusahaan'] = 'Admin/update_perusahaan';


$route['data-kriteria'] = 'Admin/kriteria';
$route['get_edit_kriteria'] = 'Admin/get_edit_kriteria';
$route['simpan_edit_kriteria'] = 'Admin/simpan_edit_kriteria';
$route['simpan-kriteria'] = 'Admin/simpan_kriteria';
$route['hapus_kriteria'] = 'Admin/hapus_kriteria';



$route['data-alternatif'] = 'Admin/alternatif';
$route['get_edit_alternatif'] = 'Admin/get_edit_alternatif';
$route['simpan_edit_alternatif'] = 'Admin/simpan_edit_alternatif';
$route['simpan-alternatif'] = 'Admin/simpan_alternatif';
$route['hapus_alternatif'] = 'Admin/hapus_alternatif';


// DIVISI AREA
$route['ubahpassword_divisi'] = 'Divisi/ubahpassword';
$route['authdiv'] = 'LoginDivisi';
$route['authdiv_proc'] = 'LoginDivisi/proses_login';
$route['outdiv'] = 'LoginDivisi/logout';
$route['homediv'] = 'Divisi';
$route['regis_perusahaan'] = 'LoginDivisi/register';
$route['verifikasi_perusahaan'] = 'LoginDivisi/verifikasi';
$route['simpan_akun_perusahaan'] = 'LoginDivisi/simpan_akun';

$route['m-lamaran-div'] = 'Divisi/lamaran';
$route['cek_lamaran_div'] = 'Divisi/cek_lamaran';
$route['cek_berkas_div'] = 'Divisi/cek_berkas';
$route['terima_pelamar'] = 'Divisi/terima_pelamar';


$route['data_lowongan'] = 'Divisi/lowongan';
$route['div/simpan_lowongan'] = 'Divisi/simpan_lowongan';
$route['div/detail_lowongan'] = 'Divisi/detail_lowongan';
$route['div/edit_lowongan'] = 'Divisi/edit_lowongan';
$route['div/sedit_lowongan'] = 'Divisi/simpan_edit_lowongan';
$route['div/hapus_lowongan'] = 'Divisi/hapus_lowongan';
$route['hasil_pelamar'] = 'Divisi/get_hasil_pelamar';



// USER AREA
$route['masuk'] = 'LoginUser';
$route['keluar'] = 'LoginUser/logout';
$route['register'] = 'LoginUser/register';
$route['cek_email'] = 'LoginUser/cek_email';
$route['masuk_proc'] = 'LoginUser/login';
$route['verifikasi'] = 'LoginUser/verifikasi';
$route['simpan_akun'] = 'LoginUser/simpan_akun';
$route['ubahpassword'] = 'Pelamar/ubah_password';


//Dashboard Pelamar

$route['home'] = 'Pelamar';
$route['myprofile/pribadi'] = 'Pelamar/data_pribadi';
$route['myprofile/pendidikan'] = 'Pelamar/data_pendidikan';
$route['myprofile/pekerjaan'] = 'Pelamar/data_pekerjaan';


$route['simpan_pribadi'] = 'Pelamar/simpan_data_pribadi';

$route['simpan_pendidikan'] = 'Pelamar/simpan_pendidikan';
$route['hapus_pendidikan'] = 'Pelamar/hapus_pendidikan';

$route['simpan_pekerjaan'] = 'Pelamar/simpan_pekerjaan';
$route['hapus_pekerjaan'] = 'Pelamar/hapus_pekerjaan';
$route['lowongan'] = 'Pelamar/data_lowongan';
$route['detail_lowongan'] = 'Pelamar/detail_lowongan';
$route['lamar_lowongan'] = 'Pelamar/lamar_lowongan';
$route['mylowongan'] = 'Pelamar/hasil_lowongan';


$route['cobamail'] = 'Api/tes_email';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
