<?php

namespace App\Http\Controllers;

use App\hbelipaketmodel;
use App\JenisPaketModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\MemberModel;
use App\PaketModel;
use App\JadwalModel;
use Carbon\Carbon;

class paketcontroller extends Controller
{
	public function tambahpaket(Request $req){
		$paketBaru = new PaketModel;
		$paketBaru->id_paket = 0;
		$paketBaru->nama_paket = $req->nama;
        $paketBaru->jenispaket = $req->jenis;
		$paketBaru->deskripsi = $req->desc;
		$paketBaru->estimasiturun = $req->estimasi;
		$paketBaru->harga = $req->harga;
		$paketBaru->durasi = $req->durasi;
		$paketBaru->status = 0;
		$paketBaru->rating = 0;
		$paketBaru->konsultan = $req->konsultan;
		$paketBaru->waktutambah = NOW();
        $paketBaru->gambar = "default.jpg";
		$paketBaru->save();
		$return[0]['status'] = "sukses";
		echo json_encode($return);
    }

	public function aktifkanPaket(Request $req){
		$paket = PaketModel::find($req->id);
		$model = new JadwalModel();
		$hsl = $model->cekJadwal($req->id);
		if($paket->status < 2){
			if($paket->durasi == count($hsl)){
				$paket->status = 1;
				$paket->save();
			}
			else{
				$paket->status = 0;
				$paket->save();
			}
		}
		else{
			$paket->status = 2;
			$paket->save();
		}
	}

    public function selesaikanTransaksi(){
        $skrg = Carbon::now();
        $tgl = $skrg->toDateString();
        $model = new hbelipaketmodel();
        $hsl = $model->getAllTransaksiOnGoing();
        for($i = 0; $i < count($hsl); $i++){
            if($hsl[$i]->tanggalselesai == $tgl){
                $hsl[$i]->status = 5;
                $hsl[$i]->save();
            }
        }
    }

	public function getPaket(Request $req){
		$model = new PaketModel;
		$paket = $model->getPaket();
		$return[0]['paket'] = $paket;
        $this->selesaikanTransaksi();
		echo json_encode($return);
	}

    public function searchPaketMember(Request $req){
        $model = new PaketModel();
        if($req->cari != ""){
            $paket = $model->searchPaketMember($req->cari);
        }
        else{
            $paket = $model->getPaket();
        }
        $return[0]['paket'] = $paket;
		echo json_encode($return);
    }

	public function getPaketkonsultan(Request $req){
		$model = new PaketModel();
		$paket = $model->getPaketKonsultan($req->id);
		$return[0]['paket'] = $paket;
        $this->selesaikanTransaksi();
		echo json_encode($return);
	}

	public function getPaketById(Request $req){
		$model = new PaketModel();
		$paket = $model->getPaketById($req->id);
		$return[0]['paket'] = $paket;
		echo json_encode($return);
	}

    public function getJenisPaket(){
        $return[0]['jenis'] = JenisPaketModel::all();
        echo json_encode($return);
    }

	public function updatePaket(Request $req){
		$model = new PaketModel();
		$nama = $req->nama;
		$desc = $req->desc;
		$estimasi = $req->estimasi;
		$harga = $req->harga;
		$durasi = $req->durasi;
        $id = $req->id;
		$model->updatePaket($id, $nama, $desc, $estimasi, $harga, $durasi);
	}
}
