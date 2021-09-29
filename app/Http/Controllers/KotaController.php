<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KotaModel;
use App\ProvinsiModel;

class KotaController extends Controller
{
    public function getKotaByProvince(Request $req){
		$model = new KotaModel();
        $hsl = $model->getKotaByProvinsi($req->prov);
        $return = [];
        $return[0]['kota'] = $hsl;
        echo json_encode($return);
	}

    public function getProvinsi(Request $req){
        $hsl = ProvinsiModel::all();
        $return = [];
        $return[0]['provinsi'] = $hsl;
        echo json_encode($return);
    }

    public function getKotaAwal(Request $req){
        $id = $req->idkota;
        $city = KotaModel::find($id);
        $return = [];
        $return[0]['kota'] = $city;
        echo json_encode($return);
    }

    public function getProvinsiAwal(Request $req){
        $id = $req->idprovinsi;
        $city = ProvinsiModel::find($id);
        $return = [];
        $return[0]['provinsi'] = $city;
        echo json_encode($return);
    }
}
