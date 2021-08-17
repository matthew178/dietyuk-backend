<?php

namespace App\Http\Controllers;

use App\SaldoModel;
use Illuminate\Http\Request;

class saldocontroller extends Controller
{
    public function topup(Request $req){
        $saldo = new SaldoModel();
        $saldo->id = 0;
        $saldo->id_user = $req->id_user;
        $saldo->saldo = $req->saldo;
        $saldo->status = 0;
        $saldo->waktu = date('Y-m-d H:i:s');
        $saldo->bank = $req->bank;
        $namafile = $req->m_filename;
        if($req->m_filename != ""){
            $datagambar = base64_decode($req->m_image);
            file_put_contents("gambar/buktitransfer/".$namafile, $datagambar);
            $saldo->buktitransfer = $namafile;
        }
        $saldo->save();
    }

}
