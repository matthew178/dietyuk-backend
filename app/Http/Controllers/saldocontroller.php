<?php

namespace App\Http\Controllers;

use App\MemberModel;
use App\PenarikanModel;
use App\SaldoModel;
use App\WithdrawModel;
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

    public function topupsaldo(Request $req){
        $saldo = new SaldoModel();
        $saldo->id = 0;
        $saldo->id_user = $req->user;
        $saldo->saldo = $req->saldo;
        $saldo->status = 1;
        $saldo->waktu = date('Y-m-d H:i:s');
        $saldo->bank = "Virtual Account";
        $saldo->buktitransfer = null;
        $saldo->save();
        $member = MemberModel::find($req->user);
        $member->saldo += $req->saldo;
        $member->save();
    }

    public function kirimReqPenarikan(Request $req){
        $penarikan = new PenarikanModel();
        $penarikan->id = 0;
        $penarikan->id_user = $req->username;
        $penarikan->saldo = $req->nominal;
        $penarikan->status = 0;
        $penarikan->waktu = date('Y-m-d H:i:s');
        $penarikan->nomorrekening = $req->norek;
        $penarikan->bank = $req->bank;
        $penarikan->atasnama = $req->atasnama;
        $penarikan->save();
        $member = MemberModel::find($req->username);
        $member->saldo -= $req->nominal;
        $member->save();

    }

    public function getHistoryTopup(Request $req){
        $model = new SaldoModel();
        $hsl = $model->getHistory($req->iduser);
        $mdl = new WithdrawModel();
        $hsl1 = $mdl->getHistoryWithdraw($req->iduser);

        $return = [];
        $return[0]['topup'] = $hsl;
        $return[0]['withdraw'] = $hsl1;
        echo json_encode($return);
    }

}
