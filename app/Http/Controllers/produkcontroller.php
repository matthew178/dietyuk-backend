<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProdukModel;

class produkcontroller extends Controller
{
    public function tambahproduk(Request $req){
		$produkBaru = new ProdukModel;
		$produkBaru->kodeproduk = 0;
		$produkBaru->konsultan = $req->nama;
		$produkBaru->namaproduk = $req->desc;
		$produkBaru->kodekategori = $req->estimasi;
		$produkBaru->kemasan = $req->harga;
		$produkBaru->harga = $req->durasi;
		$produkBaru->foto = 1;
		$produkBaru->deskripsi = 0;
		$produkBaru->status = $req->konsultan;
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
            $hsl = $model->searchProduk($req->cari);
            $return[0]['produk'] = $hsl;
        }
        else{
            $return[0]['produk'] = ProdukModel::all();
        }
        echo json_encode($return);

    }
}
