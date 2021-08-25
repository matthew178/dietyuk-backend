<?php

namespace App\Http\Controllers;

use App\laporanperkembangan;
use App\MemberModel;
use Illuminate\Http\Request;

class laporanperkembangancontroller extends Controller
{
    public function tambahPerkembangan(Request $req){
        $laporan = laporanperkembangan::find($req->id);

        if($req->harike == "0"){
            $laporan->berat = $req->berat;
            $laporan->status = 3;
            $laporan->save();
        }
        else{
            $hsl = $req->id - 1;
            $lapsebelum = laporanperkembangan::find($hsl);
            $laporan->berat = $req->berat;
            if($req->berat < $lapsebelum->berat){
                $laporan->status = 1;
                echo "1";
            }
            else if($req->berat == $lapsebelum->berat){
                $laporan->status = 3;
                echo "3";
            }
            else if($req->berat > $lapsebelum->berat){
                $laporan->status = 2;
                echo "2";
            }
            $laporan->save();
        }
        $report = laporanperkembangan::where('idbeli', '=', $req->idbeli)
								->orderby('id')
								->get();
        $oldberat = 0;
        foreach($report as $row) {
            // utk ganti status
            $status = 0;
            if($row->berat > 0) {
                if($row->harike == 0) { $status = 3; $oldberat = $row->berat; }
                else {
                    if($row->berat > $oldberat) { $status = 2; }
                    else if($row->berat < $oldberat) { $status = 1;}
                    else { $status = 3; }

                    $oldberat = $row->berat;
                }

                $lapupdate = laporanperkembangan::find($row->id);
                $lapupdate->status = $status;
                $lapupdate->save();
            }
        }
        $member = MemberModel::find($req->user);
        $member->berat = $req->berat;
        $member->save();
        // $res = laporanperkembangan::where('idbeli','=',$req->idbeli)->get();
        // $prevberat = 0;
        // $ctr = 0;
        // foreach ($res as $row) {
        //     if($ctr == 0){
        //         $prevberat = $row->berat;
        //     }
        //     if($row->harike == $req->harike){
        //         $ctr++;
        //     }
        // }
        // if($prevberat == 0){
        //     $laporan->status = 3;
        // }
        // else{
        //     if($req->berat < $prevberat){
        //         $laporan->status = 1;
        //     }
        //     else if($req->berat == $prevberat){
        //         $laporan->status = 3;
        //     }
        //     else if($req->berat > $prevberat){
        //         $laporan->status = 2;
        //     }
        // }
        // $laporan->save();
        // echo $req->berat. " " . $prevberat. " " . $laporan->status;
        // $member = MemberModel::find($req->user);
        // $member->berat = $req->berat;
        // $member->save();
    }
}
