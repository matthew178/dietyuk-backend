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

    public function searchInfo(Request $req){
        $consumer_key = "6156ad50311c4f06b44c74f4d3faf814";
        $secret_key = "93cfdd942c1e426f826867bdab74ebbe";

        $base = rawurlencode("GET")."&";
        $base .= "http%3A%2F%2Fplatform.fatsecret.com%2Frest%2Fserver.api&";
        $params = "format=json&";
        $params .= "method=foods.search&";
        $params .= "oauth_consumer_key=$consumer_key&";
        $params .= "oauth_nonce=".rand()."&";
        $params .= "oauth_signature_method=HMAC-SHA1&";
        $params .= "oauth_timestamp=".time()."&";
        $params .= "oauth_version=1.0&";
        $params .= "search_expression=".$req->search;

        $params2 = rawurlencode($params);
        $base .= $params2;

        $sig= base64_encode(hash_hmac('sha1', $base, "$secret_key&",
            true));

        $url = "http://platform.fatsecret.com/rest/server.api?".
            $params."&oauth_signature=".rawurlencode($sig);

        list($output,$error,$info) = $this->loadFoods($url);
        if($error == 0){
            if($info['http_code'] == '200')
                echo json_encode($output);
            else
                die('Status INFO : '.$info['http_code']);
        }

        else
            die('Status ERROR : '.$error);
    }

    function loadFoods($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return array($output,$error,$info);
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
