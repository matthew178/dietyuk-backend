<?php

namespace App\Http\Controllers;

use App\dbeliModel;
use App\hbelipaketmodel;
use Illuminate\Http\Request;
use App\JadwalModel;
use Carbon\Carbon;

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

    public function kurangSpek(Request $req){
        $jadwal = dbeliModel::find($req->id)->delete();
        echo "sukses";
    }

    public function tambahSpek(Request $req){
        $cari = hbelipaketmodel::find($req->idbeli);
        $sekarang = Carbon::createFromFormat('Y-m-d', $cari->tanggalaktifasi);
        $jadwalBaru = new dbeliModel();
		$jadwalBaru->id = 0;
		$jadwalBaru->idbeli = $req->idbeli;
		$jadwalBaru->tanggal = $sekarang->addDays($req->hari);
        $jadwalBaru->hari = $req->hari;
        $jadwalBaru->waktu = $req->waktu;
        $jadwalBaru->keterangan = $req->ket;
        $jadwalBaru->takaran = $req->takaran;
        $jadwalBaru->status = 0;
		$jadwalBaru->save();
		$return[0]['status'] = "sukses";
		echo json_encode($return);
    }
}
