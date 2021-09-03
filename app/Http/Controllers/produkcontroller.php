<?php

namespace App\Http\Controllers;

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

    public function cariProduk(Request $req){
        if($req->cari != ""){
            $model = new ProdukModel();
            $hsl = $model->searchProduk($req->cari,$req->id);
            $return[0]['produk'] = $hsl;
        }
        else{
            $model = new ProdukModel();
            $hsl = $model->getProdukByKategori($req->id);
            $return[0]['produk'] = $hsl;
        }
        echo json_encode($return);

    }
}
