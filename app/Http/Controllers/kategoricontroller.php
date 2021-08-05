<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KategoriModel;

class kategoricontroller extends Controller
{
    public function getallkategori(Request $req){
        // $model = new KategoriModel();
        $hsl = KategoriModel::all();
        $return = [];
        $return[0]['kategori'] = $hsl;
        echo json_encode($return);
    }
}
