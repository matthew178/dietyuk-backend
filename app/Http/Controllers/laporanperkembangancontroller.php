<?php

namespace App\Http\Controllers;

use App\laporanperkembangan;
use App\MemberModel;
use Illuminate\Http\Request;

class laporanperkembangancontroller extends Controller
{
    public function tambahPerkembangan(Request $req){
        $laporan = laporanperkembangan::find($req->id);
        $laporan->berat = $req->berat;
        $laporan->status = 1;
        $laporan->save();
        $member = MemberModel::find($req->user);
        $member->berat = $req->berat;
        $member->save();
    }
}
