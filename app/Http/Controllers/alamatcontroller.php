<?php

namespace App\Http\Controllers;

use App\AlamatModel;
use Illuminate\Http\Request;

class alamatcontroller extends Controller
{
    public function tambahAlamat(Request $req){
        $alamat = new AlamatModel();
        $alamat->id = 0 ;
        $alamat->username = $req->username;
        $alamat->provinsi = $req->provinsi;
        $alamat->kota = $req->kota;
        $alamat->alamat_detail = $req->detail;
        $alamat->penerima = $req->penerima;
        $alamat->nomortelepon = $req->nohp;
        $alamat->save();
        $return = [];
        $return[0]['status'] = "Berhasil tambah alamat";
        echo json_encode($return);
    }

    public function daftarAlamat(Request $req){
        $model = new AlamatModel();
        $hsl = $model->getAlamatUser($req->userlogin);
        $return = [];
        $return[0]['alamat'] = $hsl;
        echo json_encode($return);
    }
}
