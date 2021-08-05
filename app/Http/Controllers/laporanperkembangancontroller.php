<?php

namespace App\Http\Controllers;

use App\laporanperkembangan;
use Illuminate\Http\Request;

class laporanperkembangancontroller extends Controller
{
    public function getLaporan(Request $req){
        $model = new laporanperkembangan();
        $hsl = $model->getLaporanById($req->idbeli);
        $return[0]['laporan'] = $hsl;
        echo json_encode($return);
    }
}
