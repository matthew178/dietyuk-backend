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
Route::post('/tambahLibur',"usercontroller@tambahLibur");
Route::post('/selesaikanTransaksi',"admincontroller@selesaikanTransaksi");
Route::get('/konfirmasiakun/{email}',"usercontroller@konfirmasiAkun");
Route::post('/kirimEmailAktivasi',"usercontroller@kirimEmailAktivasi");
Route::post('/getDataCustomer',"usercontroller@getDataCustomer");
// Route::post('/sendNotification', "usercontroller@sendNotification");
Route::post('/dailycheckup', "usercontroller@dailycheckup");
Route::post('/makanpagi', "usercontroller@ingatMakanPagi");
Route::post('/makansiang', "usercontroller@ingatMakanSiang");
Route::post('/makanmalam', "usercontroller@ingatMakanMalam");
Route::post('/olahraga', "usercontroller@olahraga");

Route::post('/getHistoryBerat',"usercontroller@getHistoryBerat");

//paket
Route::post('/tambahpaket',"paketcontroller@tambahpaket");
Route::post('/updatepaket',"paketcontroller@updatepaket");
Route::post('/getpaket',"paketcontroller@getPaket");
Route::post('/getpaketkonsultan',"paketcontroller@getPaketkonsultan");
Route::post('/getpaketbyid',"paketcontroller@getPaketById");
Route::get('/getjenispaketmember',"paketcontroller@getjenispaket");
Route::post('/aktifkanPaket', "paketcontroller@aktifkanPaket");
Route::post('/searchPaketMember',"paketcontroller@searchPaketMember");
Route::post('/filterpaket',"paketcontroller@getFilterPaket");
Route::post('/searchPaketKonsultan', "paketcontroller@searchPaketKonsultan");
Route::post('/onOffPaket',"paketcontroller@onOffPaket");
Route::post('/getLaporanPaket',"paketcontroller@getLaporanPaket");
Route::post('/getDetailLaporan',"paketcontroller@getDetailLaporan");

//jadwal
Route::post('/getjadwalbyid',"jadwalcontroller@getJadwalById");
Route::post('/tambahjadwal',"jadwalcontroller@tambahjadwal");
Route::post('/hapusjadwal',"jadwalcontroller@hapusjadwal");
Route::post('/getdetailbyid', "jadwalcontroller@getdetailbyid");
Route::post('/kurangSpek',"jadwalcontroller@kurangSpek");
Route::post('/tambahSpek',"jadwalcontroller@tambahSpek");
Route::post('/cariInformasi',"jadwalcontroller@searchInfo");

//produk
Route::post('/getprodukbykonsultan', "produkcontroller@getprodukkonsultan");
Route::post('/getProdukKategori',"produkcontroller@getProduk");
Route::post('/getProdukDetail',"produkcontroller@getProdukDetail");
Route::post('/searchProduk',"produkcontroller@cariProduk");
Route::post('/tambahproduk',"produkcontroller@tambahproduk");
Route::post('/getProdukCart',"produkcontroller@getProdukCart");
Route::post('/editProduk',"produkcontroller@editproduk");
Route::post('/searchProdukKonsultan', "produkcontroller@searchProdukKonsultan");
Route::post('/searchfilterProduk',"produkcontroller@searchfilterProduk");
Route::post('/getLaporanProduk',"produkcontroller@getLaporanProduk");
Route::post('/getDetailLaporanProduk',"produkcontroller@getDetailLaporanProduk");

Route::get('/tesRouting',"Controller@tes");

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
Route::post('/getTransaksiPaketKonsultan',"belipaketcontroller@getTransaksiPaketKonsultan");

//review
Route::post('/getreviewpaket',"paketcontroller@getreviewpaket");
Route::post('/kirimRating',"belipaketcontroller@kirimRating");
Route::post('/submitReport',"belipaketcontroller@submitReport");
Route::post('/ubahStatusTestimoni',"paketcontroller@ubahStatusTestimoni");
Route::post('/getTestiPaket',"paketcontroller@getTestiPaket");

Route::get('/kirim-email', 'Controller@index');

//beliproduk
Route::post('/checkout', "beliprodukcontroller@checkout");
Route::post('/getTransaksiProdukKonsultan',"beliprodukcontroller@getTransaksiProdukKonsultan");
Route::post('/getTransaksiPacking',"beliprodukcontroller@getTransaksiPacking");
Route::post('/getTransaksiKirim',"beliprodukcontroller@getTransaksiKirim");
Route::post('/getTransaksiProdukPacking',"beliprodukcontroller@getTransaksiPacking");
Route::post('/getTransaksiProdukKirim',"beliprodukcontroller@getTransaksiProdukKirim");
Route::post('/getTransaksiProdukSelesai',"beliprodukcontroller@getTransaksiProdukSelesai");
Route::post('/getDetailTransProduk',"beliprodukcontroller@getDetailTransProduk");
Route::post('/tolakTransaksiProduk',"beliprodukcontroller@tolakTransaksi");
Route::post('/terimaPesanan',"beliprodukcontroller@terimapesanan");
Route::post('/updateResi',"beliprodukcontroller@updateResi");
Route::post('/getTransaksiPackingMember',"beliprodukcontroller@getTransaksiPackingMember");
Route::post('/getTransaksiKirimMember',"beliprodukcontroller@getTransaksiProdukKirimMember");
Route::post('/getTransaksiSelesaiMember',"beliprodukcontroller@getTransaksiProdukSelesaiMember");
Route::post('/selesaikanPesananMember',"beliprodukcontroller@selesaikanPesananMember");

//alamat
Route::post('/tambahAlamat', "alamatcontroller@tambahAlamat");
Route::post('/getDaftarAlamat',"alamatcontroller@daftarAlamat");

//kota
Route::post('/getKotaByProvinsi', "KotaController@getKotaByProvince");
Route::get('/getProvinsi', "KotaController@getProvinsi");

//kategori
Route::post('/getkategori', "kategoricontroller@getallkategori");
Route::post('/tambahkategori', "kategoricontroller@tambahkategori");

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
Route::post('/getHistoryTopup',"saldocontroller@getHistoryTopup");
Route::post('/tambahsaldo',"saldocontroller@topupsaldo");
Route::post('/kirimReqPenarikan',"saldocontroller@kirimReqPenarikan");
Route::post('/getHistoryTopupLaporan',"saldocontroller@getHistoryTopupLaporan");

//chat
Route::post('/cekPesan',"chatcontroller@cekPesan");
Route::post('/getListChat',"chatcontroller@getListChatUser");

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
Route::post('/konfirmasipenarikan',"admincontroller@konfirmasipenarikan");

Route::get('/logoutadmin',"admincontroller@logout");

//admin -> get
Route::group(['middleware' => ['CekSessionAdmin']], function () {
    Route::get('/admin', function () {
        return view('dashboard');});
    Route::get('/jenispaket',"admincontroller@jenispaket");
    Route::get('/jenisproduk',"admincontroller@jenisproduk");
    Route::get('/confirmkonsultan',"admincontroller@confirmkonsultan");
    Route::get('/confirmsaldo',"admincontroller@confirmsaldo");
    Route::get('/confirmpenarikan',"admincontroller@confirmpenarikan");
    Route::get('/mastermember',"admincontroller@mastermember");
    Route::get('/masterpaket',"admincontroller@masterpaket");
    Route::get('/block/{id}',"admincontroller@blockuser");
    Route::get('/aktifkan/{id}',"admincontroller@aktifkanuser");
    Route::get('/blockpaket/{id}',"admincontroller@blockpaket");
    Route::get('/aktifkanpaket/{id}',"admincontroller@aktifkanpaket");
    Route::get('/laporanpenjualanpaket',"admincontroller@laporanpenjualanpaket");
    Route::get('/laporanpenjualanproduk',"admincontroller@laporanpenjualanproduk");
    Route::get('/getReportKonsultanAdmin',"admincontroller@reportKonsultanAdmin");
    Route::get('/chat',"admincontroller@listchat");
    Route::get('/blockkonsultan/{id}',"admincontroller@blockkonsultan");
    Route::get('/ubahStatusReport/{id}',"admincontroller@ubahstatusreport");
});

    Route::get('/detailbulanproduk/{tahun}/{bulan}',"admincontroller@detailbulanproduk");
    Route::get('/getCountKonsultan',"admincontroller@getKonsultanTerlaris");
    Route::get('/detailbulan/{tahun}/{bulan}',"admincontroller@detailbulanpaket");


// Route::post('/detailbulanproduk',"admincontroller@detailbulanproduk");

