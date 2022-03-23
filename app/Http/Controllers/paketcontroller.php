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
use App\RatingPaketKonsultanModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
		$paketBaru->status = 3;
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

    public function getFilterPaket(Request $req){
        if($req->qry != ""){
            $hsl = DB::select(DB::raw("SELECT * FROM paket WHERE ".$req->qry));
        }
        else{
            $hsl = DB::select(DB::raw("SELECT * FROM paket"));
        }
        $model = new PaketModel;
		$paket = $model->getPaket();
        $rtn = [];
        for($i = 0; $i < count($hsl); $i++){
            for($j = 0; $j < count($paket); $j++){
                if($hsl[$i]->id_paket == $paket[$j]->id_paket){
                    $rtn[$i] = $paket[$j];
                }
            }
        }
        $return[0]['paket'] = $rtn;
        echo json_encode($return);
    }

    public function getLaporanPaket(Request $req){
        $model = new PaketModel();
        $hsl = $model->getLaporanPaket($req->konsultan);
        if(count($hsl) > 0)
            $return[0]['datalaporan'] = $hsl;
        else
            $return[0]['datalaporan'] = "tidak ada data";
        $hsl2 = $model->getLapPaketRating($req->konsultan);
        $hsl3 = $model->getLaporanPaketTerfav($req->konsultan);
        $return[0]['rating'] = $hsl2;
        $return[0]['fav'] = $hsl3;
        $laporan = $model->getSemuaPaketKonsultan($req->konsultan);
        $return[0]['laporan'] = $laporan;
        echo json_encode($return);
    }

    public function getDetailLaporan(Request $req){
        $model = new PaketModel();
        $arrMonth = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
          ];
        for($i = 0; $i < count($arrMonth); $i++){
            if($req->bulan == $arrMonth[$i]){
                $bulan = $i+1;
            }
        }
        $hsl = $model->getDetailLaporanPaket($req->konsultan,$bulan, $req->tahun);
        if(count($hsl) > 0)
            $return[0]['datalaporan'] = $hsl;
        else
            $return[0]['datalaporan'] = "tidak ada data";
        $laporan = $model->getSemuaPaketKonsultan($req->konsultan);
        $return[0]['laporan'] = $laporan;
        echo json_encode($return);
    }

    public function searchPaketKonsultan(Request $req){
        $model = new PaketModel();
        if($req->cari != ""){
            $paket = $model->searchPaketKonsultan($req->cari,$req->konsultan);
        }
        else{
            $paket = $model->getPaketKonsultan($req->konsultan);
        }
        $return[0]['paket'] = $paket;
		echo json_encode($return);
    }

    public function onOffPaket(Request $req){
        $paket = PaketModel::find($req->paket);
        if($paket->status == 0){
            $paket->status = 1;
        }
        else if($paket->status == 1){
            $paket->status = 0;
        }
        $paket->save();
        $model = new PaketModel();
		$paket = $model->getPaketKonsultan($req->id);
		$return[0]['paket'] = $paket;
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

    public function getreviewpaket(Request $req){
        $model = new RatingPaketKonsultanModel();
        $hsl = $model->getReviewPaket($req->id);
        $return[0]['review'] = $hsl;
		echo json_encode($return);
    }
}
