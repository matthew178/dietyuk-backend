<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\dbeliModel;
use App\hbelipaketmodel;
use App\JadwalModel;
use App\laporanperkembangan;
use App\MemberModel;
use Illuminate\Http\Request;

class belipaketcontroller extends Controller
{
    public function belipaket(Request $req){
		$beliPaketBaru = new hbelipaketmodel;
		$beliPaketBaru->id = 0;
        $beliPaketBaru->idpaket = $req->id;
        $beliPaketBaru->iduser = $req->user;
        $beliPaketBaru->tanggalbeli = NOW();
        $beliPaketBaru->tanggalaktifasi = null;
        $beliPaketBaru->durasi = $req->durasi;
        $beliPaketBaru->totalharga = $req->total;
        $beliPaketBaru->keterangan = "";
        $beliPaketBaru->status = 0;
        $beliPaketBaru->save();
        $user = MemberModel::find($req->user);
        $user->saldo = $user->saldo - $req->total;
        $user->save();
		$return[0]['status'] = "berhasil";
		echo json_encode($return);
    }

    public function getPaketBelumSelesai(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->getTransaksiBelumAktif($req->user);
		$return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function onProsesPaket(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->onProses($req->user);
		$return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function getPaketSelesai(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->getTransaksiSelesai($req->user);
		$return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function getPaketBatal(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->getTransaksiBatal($req->user);
		$return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function aktivasiPaket(Request $req){
        $model = new JadwalModel();
		$paket = $model->getJadwalById($req->paket);
		$return = [];
		$return[0]['jadwal'] = $paket;
        $temp = 0;
        $hariini = Carbon::now();
        $lap = new laporanperkembangan();
        $lap->id = 0;
        $lap->idbeli = $req->id;
        $lap->username = $req->username;
        $lap->berat = $req->berat;
        $lap->status = 0;
        $lap->harike = 0;
        $lap->tanggal = $hariini->addDays(1);
        $lap->save();
        for ($i=0; $i < count($paket); $i++) {
            $hariini = Carbon::now();
            $detail = new dbeliModel;
            $detail->id = 0;
            $detail->idbeli = $req->id;
            if($i > 0){
                if($paket[$i]->hari == $paket[$i - 1]->hari){
                    $detail->tanggal = $hariini->addDays($temp);
                }
                else{
                    $temp++;
                    $detail->tanggal = $hariini->addDays($temp);
                }
            }
            else{
                $detail->tanggal = $hariini->addDays($i);
            }
            $detail->hari = $paket[$i]->hari;
            $detail->waktu = $paket[$i]->waktu;
            $detail->keterangan = $paket[$i]->keterangan;
            $detail->takaran = $paket[$i]->takaran;
            $detail->status = 0;
            $detail->save();
        }
        $laporan = new dbeliModel();
        $hsl = $laporan->getHari($req->id);
        for($i = 0;$i<count($hsl);$i++){
            $hariini = Carbon::now();
            if($hsl[$i]->hari % 3 == 0){
                $laporan = new laporanperkembangan();
                $laporan->id = 0;
                $laporan->idbeli = $req->id;
                $laporan->username = $req->username;
                $laporan->berat = 0;
                $laporan->status = 0;
                $laporan->harike = $hsl[$i]->hari;
                $laporan->tanggal = $hsl[$i]->tanggal;
                $laporan->save();
            }
        }
        $model = new hbelipaketmodel();
        $temp = $model->aktivasiPaket($req->id);
        $return[0]['transaksi'] = $temp;
		echo json_encode($return);
    }

    public function getDetailBeli(Request $req){
        $model = new dbeliModel();
        $hsl = $model->getDetail($req->id);
        $return[0]['detail'] = $hsl;
        $model = new laporanperkembangan();
        $hsl = $model->getLaporanById($req->id);
        $return[0]['laporan'] = $hsl;
		echo json_encode($return);
    }

    public function getJadwalHarian(Request $req){
        $model = new dbeliModel();
        $hsl = $model->getJadwalHarian($req->id, $req->hari);
        $return[0]['jadwal'] = $hsl;
		echo json_encode($return);
    }

    public function ubahstatus(Request $req){
        $model = new dbeliModel();
        $hsl = $model->ubahStatusJadwal($req->id, $req->status);
    }
}
