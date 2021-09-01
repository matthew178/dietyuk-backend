<?php

namespace App\Http\Controllers;

use App\dbeliModel;
use Illuminate\Http\Request;
use App\JadwalModel;

class jadwalcontroller extends Controller
{
    public function getJadwalById(Request $req){
		$model = new JadwalModel();
		$paket = $model->getJadwalById($req->id);
		$return = [];
		$return[0]['jadwal'] = $paket;
		echo json_encode($return);
	}

    public function getdetailbyid(Request $req){
		$model = new dbeliModel();
		$paket = $model->detailbyid($req->id);
		$return = [];
		$return[0]['jadwal'] = $paket;
		echo json_encode($return);
	}

	public function tambahjadwal(Request $req){
		$jadwalBaru = new JadwalModel;
		$jadwalBaru->id = 0;
		$jadwalBaru->id_paket = $req->id;
		$jadwalBaru->hari = $req->hari;
		$jadwalBaru->waktu = $req->waktu;
		$jadwalBaru->keterangan = $req->ket;
        $jadwalBaru->takaran = $req->takaran;
		$jadwalBaru->save();
		$return[0]['status'] = "sukses";
		echo json_encode($return);
    }

    public function hapusjadwal(Request $req){
        $jadwal = JadwalModel::find($req->id)->delete();
        echo "sukses";
    }
}
