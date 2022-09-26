<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\dbeliModel;
use App\hbelipaketmodel;
use App\JadwalModel;
use App\laporanperkembangan;
use App\MemberModel;
use App\PaketModel;
use App\RatingPaketKonsultanModel;
use App\ReportKonsultanModel;
use App\WithdrawModel;
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

    public function getTransaksiPaketKonsultan(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->getTransaksiPaketKonsultan($req->konsultan);
        $return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function refundPaket(Request $req){
        if($req->mode == 1){
            //konsultan diblokir
            $model = hbelipaketmodel::find($req->id);
            $user = MemberModel::find($req->username);
            $user->saldo = $user->saldo + $model->totalharga;
            $user->save();
            $model->status = 4;
            $model->save();
        }
        else{
            //batal beli paket
            $model = hbelipaketmodel::find($req->id);
            $user = MemberModel::find($req->username);
            $user->saldo = $user->saldo + $model->totalharga;
            $user->save();
            $model->status = 3;
            $model->save();
        }
    }

    public function onProsesPaket(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->onProses($req->user);
		$return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function paketBeliKonsultan(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->getBeliKonsultan($req->user);
		$return[0]['transaksi'] = $hsl;
        $hitung = [];
        for($i = 0; $i < count($hsl); $i++){
            $detail = new dbeliModel();
            $hsl1 = $detail->getCountSeharusnya($hsl[$i]->id);
            $hsl2 = $detail->getCountCentang($hsl[$i]->id);
            $hitung[$i] = (count($hsl2)/count($hsl1));
        }
        $return[0]['hitung'] = $hitung;
		echo json_encode($return);
    }

    public function paketSelesaiKonsultan(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->getSelesaiKonsultan($req->user);
		$return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function getPaketSelesai(Request $req){
        $model = new hbelipaketmodel();
        $hsl = $model->getTransaksiSelesai($req->user);
		$return[0]['transaksi'] = $hsl;
		echo json_encode($return);
    }

    public function kirimRating(Request $req){
        $cari = hbelipaketmodel::find($req->idbeli);
        $paket = PaketModel::find($cari->idpaket);
        $rating = new RatingPaketKonsultanModel();
        $rating->id = 0;
        $rating->idbeli = $req->idbeli;
        $rating->konsultan = $paket->konsultan;
        $rating->paket = $req->paket;
        $rating->ratingpaket = $req->ratingpaket;
        $rating->ratingkonsultan = $req->ratingkonsultan;
        $rating->review_konsultan = $req->reviewkonsultan;
        $rating->review_paket = $req->reviewpaket;
        $rating->save();
        $cari->status = 2;
        $cari->save();
        $konsul = new RatingPaketKonsultanModel();
        $knsl = $konsul->getRatingKonsultan($paket->konsultan);
        $ttl = 0;
        for($i = 0; $i < count($knsl); $i++){
            $ttl += $knsl[$i]->ratingkonsultan;
        }
        $ttl = $ttl/count($knsl);
        $member = MemberModel::find($paket->konsultan);
        $member->rating = $this->pembulatan($ttl);
        $member->save();
        $pkt = new RatingPaketKonsultanModel();
        $pket = $pkt->getRatingPaket($req->paket);
        $ttl = 0;
        for($i = 0; $i < count($pket); $i++){
            $ttl += $pket[$i]->ratingpaket;
        }
        $ttl = $ttl/count($pket);
        $model = PaketModel::find($req->paket);
        $model->rating = $this->pembulatan($ttl);
        $model->save();
    }

    public function pembulatan($nilai) {
        $depan = floor($nilai);
        $belakang = floor((($nilai * 10) % 10));
        print($depan);
        print($belakang);

        if($belakang < 3) { return $depan + 0.0; }
        else if($belakang < 8) { return $depan + 0.5; }
        else { return $depan + 1.0; }
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
        $temp = 1;
        $hariini = Carbon::now();
        $lap = new laporanperkembangan();
        $lap->id = 0;
        $lap->idbeli = $req->id;
        $lap->username = $req->username;
        $lap->berat = $req->berat;
        $lap->status = 0;
        $lap->harike = 0;
        $lap->tanggal = $hariini;
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
                $detail->tanggal = $hariini->addDays(1);
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
            if($i == count($hsl)){
                $lprn = new laporanperkembangan();
                $lprn->id = 0;
                $lprn->idbeli = $req->id;
                $lprn->username = $req->username;
                $lprn->berat = 0;
                $lprn->status = 0;
                $lprn->harike = 0;
                $lprn->tanggal = $hariini->addDays(count($hsl));
                $lprn->save();
            }
        }
        $model = new hbelipaketmodel();
        $temp = $model->aktivasiPaket($req->id);
        $return[0]['transaksi'] = $temp;
		echo json_encode($return);
    }

    public function submitReport(Request $req){
        $cek = new ReportKonsultanModel();
        $hsl = $cek->getReport($req->idtrans);
        if(count($hsl) > 0){
            $return[0]['pesan'] = "Sudah pernah direport";
        }
        else{
            $transaksi = hbelipaketmodel::find($req->idtrans);
            $paket = PaketModel::find($transaksi->idpaket);
            $report = new ReportKonsultanModel();
            $report->id = 0;
            $report->idtransaksi = $req->idtrans;
            $report->tanggalreport = NOW();
            $report->id_member = $transaksi->iduser;
            $report->id_konsultan = $paket->konsultan;
            $report->keterangan = $req->alasan;
            $report->save();
            $return[0]['pesan'] = "Berhasil report";
        }
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
