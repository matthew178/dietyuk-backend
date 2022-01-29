<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/register',
		'/login',
		'/tambahpaket',
		'/getprofile',
		'/editprofile',
		'/getpaket',
		'/getpaketkonsultan',
		'/getpaketbyid',
		'/getjadwalbyid',
		'/tambahjadwal',
        '/getprodukbykonsultan',
        '/getkategori',
        '/hapusjadwal',
        '/updatepaket',
        '/loginadmin',
        '/tambahjenisproduk',
        '/tambahjenispaket',
        '/searchPaket',
        '/searchMember',
        '/belipaket',
        '/getPaketBelumSelesai',
        '/getTransaksiSelesai',
        '/getTransaksiBatal',
        '/paketOnProses',
        '/aktivasiPaket',
        '/getdetailbeli',
        '/getJadwalHarian',
        '/ubahStatusJadwal',
        '/getProdukKategori',
        '/getProdukDetail',
        '/searchProduk',
        '/checkout',
        '/tambahPerkembangan',
        '/topup',
        '/hitungOngkir',
        '/getPaketBeliKonsultan',
        '/getPaketSelesaiKonsultan',
        '/getdetailbyid',
        '/tambahproduk',
        '/aktifkanPaket',
        '/kirim-email-verifikasi',
        '/resetPassword',
        '/refundPaket',
        '/getKotaByProvinsi',
        '/getKotaAwal',
        '/getProvinsiAwal',
        '/kurangSpek',
        '/tambahSpek',
        '/tesRouting',
        '/tambahLibur',
        '/searchPaketMember',
        '/getProdukCart',
        '/tambahAlamat',
        '/getDaftarAlamat',
        '/selesaikanTransaksi',
        '/getTransaksiPaketKonsultan',
        '/getTransaksiProdukKonsultan',
        '/getTransaksiPacking',
        '/getTransaksiProdukKirim',
        '/getTransaksiProdukSelesai',
        '/getDetailTransProduk',
        '/konfirmasiakun',
        '/tolakTransaksiProduk',
        '/getHistoryTopup',
        '/cekPesan',
        '/getListChat',
        '/cariInformasi',
        '/editProduk',
        '/kirimRating',
        '/kirimEmailAktivasi'
    ];
}
