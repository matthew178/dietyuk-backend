<?php

namespace App\Http\Controllers;

use App\KategoriModel;
use Illuminate\Http\Request;
use App\ProdukModel;

class produkcontroller extends Controller
{
    public function tambahproduk(Request $req){
        $kode = "PR";
        $produksemua = ProdukModel::all();
        $jum = count($produksemua)+1;
        if($jum < 10){
            $kode = $kode."00".$jum;
        }
        else if($jum > 10 && $jum < 100){
            $kode = $kode."0".$jum;
        }
        else{
            $kode = $kode.$jum;
        }
		$produkBaru = new ProdukModel();
		$produkBaru->kodeproduk = $kode;
		$produkBaru->konsultan = $req->konsultan;
		$produkBaru->namaproduk = $req->nama;
		$produkBaru->kodekategori = $req->kategori;
		$produkBaru->kemasan = $req->kemasan;
		$produkBaru->harga = $req->harga;
        $produkBaru->berat = $req->berat;
		$produkBaru->foto = $req->m_filename;
        if($req->m_filename != "default.png"){
            $datagambar = base64_decode($req->m_image);
            file_put_contents("gambar/produk/".$req->m_filename, $datagambar);
        }
		$produkBaru->deskripsi = $req->deskripsi;
		$produkBaru->status = "aktif";
        $produkBaru->varian = $req->varian;
		$produkBaru->save();
		$return[0]['status'] = "sukses";
		echo json_encode($return);
    }

    public function getProdukCart(Request $req){
        $data = json_decode($req->data);
        $arr = [];
        for ($i=0; $i < count($data); $i++) {
            $model = new ProdukModel();
            $produk = $model->getProdukDetail($data[$i]->kodeproduk);
            $arr[$i] = $produk;
        }
        $return = [];
        $return[0]['produk'] = $arr;
        echo json_encode($return);
    }

    public function getprodukkonsultan(Request $req){
        $model = new ProdukModel();
        $hsl = $model->getprodukbykonsultan($req->id);
        $return = [];
        $return[0]['produk'] = $hsl;
        echo json_encode($return);
    }

    public function getProduk(Request $req){
        if($req->id != "all"){
            $model = new ProdukModel();
            $hsl = $model->getProdukByKategori($req->id);
            // $return = [];
            $return[0]['produk'] = $hsl;
        }
        else{
            $return[0]['produk'] = ProdukModel::all();
        }
        echo json_encode($return);
    }

    public function getProdukDetail(Request $req){
        $model = new ProdukModel();
        $hsl = $model->getProdukDetail($req->kodeproduk);
        $return[0]['produk'] = $hsl;
        echo json_encode($return);
    }

    public function editproduk(Request $req){
        $produk = ProdukModel::find($req->idproduk);
        $produk->namaproduk = $req->nama;
        $produk->kodekategori = $req->kategori;
        $produk->kemasan = $req->kemasan;
        $produk->berat = $req->berat;
        $produk->harga = $req->harga;
        $produk->deskripsi = $req->desc;
        $produk->varian = $req->varian;
        if($req->m_filename != ""){
            $datagambar = base64_decode($req->m_image);
            file_put_contents("gambar/produk/".$req->m_filename, $datagambar);
            $produk->foto = $req->m_filename;
        }
        $produk->save();
        $return[0]['status'] = 'berhasil';
        echo json_encode($return);
    }

    public function searchProdukKonsultan(Request $req){
        if($req->cari != ""){
            $model = new ProdukModel();
            $hsl = $model->searchProdukKonsultan($req->cari,$req->konsultan);
            $return[0]['produk'] = $hsl;
        }
        else{
            $model = new ProdukModel();
            $hsl = $model->getprodukbykonsultan($req->konsultan);
            $return[0]['produk'] = $hsl;
        }
        echo json_encode($return);
    }

    public function searchfilterProduk(Request $req){
        if($req->id != "all"){
            if($req->cari != "" && $req->hargaawal != "" && $req->hargaakhir != ""){
                $model = new ProdukModel();
                $hsl = $model->searchFilterProduk($req->cari,$req->id,$req->hargaawal,$req->hargaakhir);
                $return[0]['produk'] = $hsl;
                $return[0]['status'] = "lengkap";
            }
            else if($req->cari == "" && $req->hargaawal != "" && $req->hargaakhir != ""){
                $model = new ProdukModel();
                $hsl = $model->filterProduk($req->id,$req->hargaawal,$req->hargaakhir);
                $return[0]['produk'] = $hsl;
                $return[0]['status'] = "awalakhir";
            }
            else if($req->cari == "" && $req->hargaawal == "" && $req->hargaakhir != ""){
                $model = new ProdukModel();
                $hsl = $model->filterakhir($req->id,$req->hargaakhir);
                $return[0]['produk'] = $hsl;
                $return[0]['status'] = "akhir";
            }
            else if($req->cari == "" && $req->hargaawal != "" && $req->hargaakhir == ""){
                $model = new ProdukModel();
                $hsl = $model->filterawal($req->id,$req->hargaawal);
                $return[0]['produk'] = $hsl;
                $return[0]['status'] = "awal";
            }
            else{
                if($req->id != "all"){
                    $model = new ProdukModel();
                    $hsl = $model->getProdukByKategori($req->id);
                    $return[0]['produk'] = $hsl;
                }
                else{
                    $return[0]['produk'] = ProdukModel::all();
                }

            }
        }
        else{
            if($req->cari != "" && $req->hargaawal != "" && $req->hargaakhir != ""){
                $model = new ProdukModel();
                $hsl = $model->searchFilterProduk1($req->cari,$req->id,$req->hargaawal,$req->hargaakhir);
                $return[0]['produk'] = $hsl;
                $return[0]['status'] = "lengkap1";
            }
            else if($req->cari == "" && $req->hargaawal != "" && $req->hargaakhir != ""){
                $model = new ProdukModel();
                $hsl = $model->filterProduk1($req->id,$req->hargaawal,$req->hargaakhir);
                $return[0]['produk'] = $hsl;
                $return[0]['status'] = "awalakhir1";
            }
            else if($req->cari == "" && $req->hargaawal == "" && $req->hargaakhir != ""){
                $model = new ProdukModel();
                $hsl = $model->filterakhir1($req->id,$req->hargaakhir);
                $return[0]['produk'] = $hsl;
                $return[0]['status'] = "akhir1";
            }
            else if($req->cari == "" && $req->hargaawal != "" && $req->hargaakhir == ""){
                $model = new ProdukModel();
                $hsl = $model->filterawal1($req->id,$req->hargaawal);
                $return[0]['produk'] = $hsl;
                $return[0]['status'] = "awal1";
            }
        }

        echo json_encode($return);
    }

    public function cariProduk(Request $req){
        if($req->cari != ""){
            if($req->id != "all"){
                $model = new ProdukModel();
                $hsl = $model->searchProduk($req->cari,$req->id);
                $return[0]['produk'] = $hsl;
            }
            else{
                $model = new ProdukModel();
                $hsl = $model->searchProduk1($req->cari,$req->id);
                $return[0]['produk'] = $hsl;
            }
        }
        else{
            if($req->id != "all"){
                $model = new ProdukModel();
                $hsl = $model->getProdukByKategori($req->id);
                $return[0]['produk'] = $hsl;
            }
            else{
                $return[0]['produk'] = ProdukModel::all();
            }

        }
        echo json_encode($return);
    }

    public function getLaporanProduk(Request $req){
        $model = new ProdukModel();
        $hsl = $model->getLaporanProduk($req->konsultan);
        if(count($hsl) > 0)
            $return[0]['datalaporan'] = $hsl;
        else
            $return[0]['datalaporan'] = "tidak ada data";
        $hsl2 = $model->getProdukFav($req->konsultan);
        $return[0]['fav'] = $hsl2;
        $laporan = $model->getProdukByKonsultan($req->konsultan);
        $return[0]['laporan'] = $laporan;
        echo json_encode($return);
    }

    public function getDetailLaporanProduk(Request $req){
        $model = new ProdukModel();
        $arrMonth = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
          ];
        for($i = 0; $i < count($arrMonth); $i++){
            if($req->bulan == $arrMonth[$i]){
                $bulan = $i+1;
            }
        }
        $hsl = $model->getDetailLaporanProduk($req->konsultan,$bulan, $req->tahun);
        if(count($hsl) > 0)
            $return[0]['datalaporan'] = $hsl;
        else
            $return[0]['datalaporan'] = "tidak ada data";
        $laporan = $model->getProdukByKonsultan($req->konsultan);
        $return[0]['laporan'] = $laporan;
        echo json_encode($return);
    }
}
