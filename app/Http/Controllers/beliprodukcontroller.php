<?php

namespace App\Http\Controllers;

use App\dbeliModel;
use App\dbeliproduk;
use App\hbeliproduk;
use Illuminate\Http\Request;

class beliprodukcontroller extends Controller
{
    public function checkout(Request $req){
        $data = json_decode($req->data);
        $model = new hbeliproduk();
        $model->id = 0;
        $model->pemesan = $data[0]->username;
        $model->konsultan = $data[0]->konsultan;
        $model->alamat = $req->alamat;
        $model->waktubeli = date("Y-m-d H:i:s");
        $model->total = $req->total;
        $model->status = 0;
        $model->save();
        $hbeli = hbeliproduk::all();
        for ($i=0; $i < count($data); $i++) {
            $dbeli = new dbeliproduk();
            $dbeli->id = 0;
            $dbeli->idbeli = count($hbeli);
            $dbeli->idproduk = $data[$i]->kodeproduk;
            $dbeli->jumlah = $data[$i]->jumlah;
            $dbeli->harga = $data[$i]->harga;
            $dbeli->subtotal = $data[$i]->jumlah * $data[$i]->harga;
            $dbeli->save();
        }
        echo "berhasil";
        // echo $req->data;
    }
}
