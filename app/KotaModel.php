<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KotaModel extends Model
{
    protected $table= 'kota';
    protected $primaryKey = 'id_kota';
    public $incrementing = false;
    protected $fillable= [
        'id_kota',
        'id_provinsi',
        'provinsi',
        'tipe',
        'nama_kota',
        'kodepos'
    ];
    public $timestamps= false;

    public function getKotaByProvinsi($provinsi){
        return KotaModel::select('kota.*')
                        ->where("id_provinsi","=",$provinsi)
                        ->get();
    }
}
