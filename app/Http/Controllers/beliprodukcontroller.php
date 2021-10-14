<?php

namespace App\Http\Controllers;

use App\dbeliModel;
use App\dbeliproduk;
use App\hbeliproduk;
use App\MemberModel;
use Illuminate\Http\Request;

class beliprodukcontroller extends Controller
{
    public function checkout(Request $req){
        $data = json_decode($req->data);
        $member = MemberModel::find($data[0]->username);
        $member->saldo = $member->saldo - $req->total;
        $member->save();
        $model = new hbeliproduk();
        $model->id = 0;
        $model->pemesan = $data[0]->username;
        $model->konsultan = $data[0]->konsultan;
        $model->alamat = $req->alamat;
        $model->waktubeli = date("Y-m-d H:i:s");
        $model->total = $req->total;
        $model->status = 0;
        $model->kurir = $req->kurir;
        $model->totalhargaproduk = $req->totalharga;
        $model->ongkir = $req->ongkir;
        $model->keterangan = "";
        $model->service = $req->service;
        $model->nopesanan = $this->generateRandomString(10);
        $model->save();
        for ($i=0; $i < count($data); $i++) {
            $dbeli = new dbeliproduk();
            $dbeli->id = 0;
            $dbeli->idbeli = $model->id;
            $dbeli->idproduk = $data[$i]->kodeproduk;
            $dbeli->jumlah = $data[$i]->jumlah;
            $dbeli->harga = $data[$i]->harga;
            $dbeli->subtotal = $data[$i]->jumlah * $data[$i]->harga;
            $dbeli->save();
        }
        echo "berhasil";
        // echo $req->data;
    }

    public function getTransaksiProdukKonsultan(Request $req){
        $model = new hbeliproduk();
        $hsl = $model->getTransaksiProdukKonsultan($req->konsultan);
        $return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function tolakTransaksi(Request $req){
        $model = hbeliproduk::find($req->idbeli);
        $model->status = 3;
        $model->keterangan = $req->keterangan;
        $member = MemberModel::find($req->pembeli);
        $member->saldo = $member->saldo + $model->total;
        $member->save();
        $model->save();
    }

    public function getTransaksiPacking(Request $req){
        $model = new hbeliproduk();
        $hsl = $model->getTransaksiPacking($req->konsultan);;
        $detail = [];
        $hitung = [];
        for($i = 0; $i < count($hsl); $i++){
            $mdl = new dbeliproduk();
            $hasil = $mdl->getDetail($hsl[$i]->id);
            $htg = $mdl->countDetail($hsl[$i]->id);
            $detail[$i] = $hasil;
            $hitung[$i] = count($htg);
        }
        $return[0]['transaksi'] = $hsl;
        $return[0]['detail'] = $detail;
        $return[0]['hitung'] = $hitung;
        echo json_encode($return);
    }

    public function getTransaksiProdukSelesai(Request $req){
        $model = new hbeliproduk();
        $hsl = $model->getTransaksiProdukSelesai($req->konsultan);;
        $detail = [];
        $hitung = [];
        for($i = 0; $i < count($hsl); $i++){
            $mdl = new dbeliproduk();
            $hasil = $mdl->getDetail($hsl[$i]->id);
            $htg = $mdl->countDetail($hsl[$i]->id);
            $detail[$i] = $hasil;
            $hitung[$i] = count($htg);
        }
        $return[0]['transaksi'] = $hsl;
        $return[0]['detail'] = $detail;
        $return[0]['hitung'] = $hitung;
        echo json_encode($return);
    }

    public function getTransaksiProdukKirim(Request $req){
        $model = new hbeliproduk();
        $hsl = $model->getTransaksiProdukKirim($req->konsultan);;
        $detail = [];
        $hitung = [];
        for($i = 0; $i < count($hsl); $i++){
            $mdl = new dbeliproduk();
            $hasil = $mdl->getDetail($hsl[$i]->id);
            $htg = $mdl->countDetail($hsl[$i]->id);
            $detail[$i] = $hasil;
            $hitung[$i] = count($htg);
        }
        $return[0]['transaksi'] = $hsl;
        $return[0]['detail'] = $detail;
        $return[0]['hitung'] = $hitung;
        echo json_encode($return);
    }

    public function getDetailTransProduk(Request $req){
        $model = new dbeliproduk();
        $hsl = $model->countDetail($req->idbeli);
        $header = new hbeliproduk();
        $ket = $header->getDetailHeader($req->idbeli);
        $return[0]['transaksi'] = $hsl;
        $return[0]['alamat'] = $ket;
        echo json_encode($return);
    }

    public function generateRandomString($length = 20) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
