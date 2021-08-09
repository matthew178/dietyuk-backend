<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

//user
Route::post('/register',"usercontroller@register");
Route::post('/login',"usercontroller@login");
Route::post('/getprofile',"usercontroller@getProfile");
Route::post('/editprofile',"usercontroller@updateProfile");

//paket
Route::post('/tambahpaket',"paketcontroller@tambahpaket");
Route::post('/updatepaket',"paketcontroller@updatepaket");
Route::post('/getpaket',"paketcontroller@getPaket");
Route::post('/getpaketkonsultan',"paketcontroller@getPaketkonsultan");
Route::post('/getpaketbyid',"paketcontroller@getPaketById");

//jadwal
Route::post('/getjadwalbyid',"jadwalcontroller@getJadwalById");
Route::post('/tambahjadwal',"jadwalcontroller@tambahjadwal");
Route::post('/hapusjadwal',"jadwalcontroller@hapusjadwal");

//produk
Route::post('/getprodukbykonsultan', "produkcontroller@getprodukkonsultan");
Route::post('/getProdukKategori',"produkcontroller@getProduk");
Route::post('/getProdukDetail',"produkcontroller@getProdukDetail");
Route::post('/searchProduk',"produkcontroller@cariProduk");

//belipaket
Route::post('/belipaket', "belipaketcontroller@belipaket");
Route::post('/getPaketBelumSelesai', "belipaketcontroller@getPaketBelumSelesai");
Route::post('/paketOnProses', "belipaketcontroller@onProsesPaket");
Route::post('/getTransaksiSelesai', "belipaketcontroller@getPaketSelesai");
Route::post('/getTransaksiBatal', "belipaketcontroller@getPaketBatal");
Route::post('/aktivasiPaket', "belipaketcontroller@aktivasiPaket");
Route::post('/getdetailbeli',"belipaketcontroller@getDetailBeli");
Route::post('/getJadwalHarian',"belipaketcontroller@getJadwalHarian");
Route::post('/ubahStatusJadwal', "belipaketcontroller@ubahstatus");

//beliproduk
Route::post('/checkout', "beliprodukcontroller@checkout");

//kategori
Route::post('/getkategori', "kategoricontroller@getallkategori");

//laporanperkembangan


//admin -> post
Route::post('/loginadmin', "admincontroller@login");
Route::post('/tambahjenisproduk',"admincontroller@tambahjenisproduk");
Route::post('/tambahjenispaket',"admincontroller@tambahjenispaket");
Route::post('/searchPaket',"admincontroller@searchPaket");
Route::post('/searchMember',"admincontroller@searchMember");
Route::post('/detail/{username}',"admincontroller@detail");
Route::post('/terima',"admincontroller@terimakonsultan");
Route::post('/tolak',"admincontroller@tolakkonsultan");

//admin -> get
Route::get('/admin', function () {
    return view('dashboard');});
Route::get('/jenispaket',"admincontroller@jenispaket");
Route::get('/jenisproduk',"admincontroller@jenisproduk");
Route::get('/confirmkonsultan',"admincontroller@confirmkonsultan");
Route::get('/confirmsaldo',"admincontroller@confirmsaldo");
Route::get('/mastermember',"admincontroller@mastermember");
Route::get('/masterpaket',"admincontroller@masterpaket");
Route::get('/block/{id}',"admincontroller@blockuser");
Route::get('/aktifkan/{id}',"admincontroller@aktifkanuser");
Route::get('/blockpaket/{id}',"admincontroller@blockpaket");
Route::get('/aktifkanpaket/{id}',"admincontroller@aktifkanpaket");
