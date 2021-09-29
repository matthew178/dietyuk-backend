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
Route::post('/kirim-email-verifikasi', "usercontroller@kirimEmailVerifikasi");
Route::post('/resetPassword', "usercontroller@resetPass");

//paket
Route::post('/tambahpaket',"paketcontroller@tambahpaket");
Route::post('/updatepaket',"paketcontroller@updatepaket");
Route::post('/getpaket',"paketcontroller@getPaket");
Route::post('/getpaketkonsultan',"paketcontroller@getPaketkonsultan");
Route::post('/getpaketbyid',"paketcontroller@getPaketById");
Route::get('/getjenispaketmember',"paketcontroller@getjenispaket");
Route::post('/aktifkanPaket', "paketcontroller@aktifkanPaket");

//jadwal
Route::post('/getjadwalbyid',"jadwalcontroller@getJadwalById");
Route::post('/tambahjadwal',"jadwalcontroller@tambahjadwal");
Route::post('/hapusjadwal',"jadwalcontroller@hapusjadwal");
Route::post('/getdetailbyid', "jadwalcontroller@getdetailbyid");

//produk
Route::post('/getprodukbykonsultan', "produkcontroller@getprodukkonsultan");
Route::post('/getProdukKategori',"produkcontroller@getProduk");
Route::post('/getProdukDetail',"produkcontroller@getProdukDetail");
Route::post('/searchProduk',"produkcontroller@cariProduk");
Route::post('/tambahproduk',"produkcontroller@tambahproduk");

//belipaket
Route::post('/belipaket', "belipaketcontroller@belipaket");
Route::post('/getPaketBelumSelesai', "belipaketcontroller@getPaketBelumSelesai");
Route::post('/paketOnProses', "belipaketcontroller@onProsesPaket");
Route::post('/getTransaksiSelesai', "belipaketcontroller@getPaketSelesai");
Route::post('/getTransaksiBatal', "belipaketcontroller@getPaketBatal");
Route::post('/aktivasiPaket', "belipaketcontroller@aktivasiPaket");
Route::post('/refundPaket', "belipaketcontroller@refundPaket");
Route::post('/getdetailbeli',"belipaketcontroller@getDetailBeli");
Route::post('/getJadwalHarian',"belipaketcontroller@getJadwalHarian");
Route::post('/ubahStatusJadwal', "belipaketcontroller@ubahstatus");
Route::post('/getPaketBeliKonsultan', "belipaketcontroller@paketBeliKonsultan");
Route::post('/getPaketSelesaiKonsultan', "belipaketcontroller@paketSelesaiKonsultan");

Route::get('/kirim-email', 'Controller@index');

//beliproduk
Route::post('/checkout', "beliprodukcontroller@checkout");

//kota
Route::post('/getKotaByProvinsi', "KotaController@getKotaByProvince");
Route::get('/getProvinsi', "KotaController@getProvinsi");

//kategori
Route::post('/getkategori', "kategoricontroller@getallkategori");

//laporanperkembangan
Route::post('/tambahPerkembangan', "laporanperkembangancontroller@tambahPerkembangan");

//kota&ongkir
Route::get('/getKota',"usercontroller@getKota");
// Route::get('/getProvinsi',"usercontroller@getProvinsi");
Route::post('/hitungOngkir',"usercontroller@hitungOngkir");
Route::post('/getKotaAwal', "KotaController@getKotaAwal");
Route::post('/getProvinsiAwal', "KotaController@getProvinsiAwal");

//saldo
Route::post('/topup', "saldocontroller@topup");
Route::post('/updatebukti',"saldocontroller@updatebukti");

//admin -> post
Route::post('/loginadmin', "admincontroller@login");
Route::post('/tambahjenisproduk',"admincontroller@tambahjenisproduk");
Route::post('/tambahjenispaket',"admincontroller@tambahjenispaket");
Route::post('/searchPaket',"admincontroller@searchPaket");
Route::post('/searchMember',"admincontroller@searchMember");
Route::post('/detail/{username}',"admincontroller@detail");
Route::post('/terima',"admincontroller@terimakonsultan");
Route::post('/tolak',"admincontroller@tolakkonsultan");
Route::post('/konfirmasisaldo', "admincontroller@konfirmasisaldo");

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
