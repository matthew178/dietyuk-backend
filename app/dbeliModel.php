<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dbeliModel extends Model
{
    protected $table= 'dbelipaket';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'idbeli',
		'tanggal',
		'hari',
		'waktu',
        'keterangan',
        'takaran',
        'status'
    ];
    public $timestamps= false;

    public function getDetail($id){
        return dbeliModel::select("tanggal", "hari")
                            ->where("idbeli","=",$id)
                            ->distinct()
                            ->get();
    }

    public function detailbyid($id){
        return dbeliModel::select("dbelipaket.*")
                            ->where("idbeli","=",$id)
                            ->get();
    }

    public function getJadwalHarian($id, $hari){
        return dbeliModel::select("dbelipaket.*")
                            ->where("idbeli","=",$id)
                            ->where("hari","=",$hari)
                            ->get();
    }

    public function ubahStatusJadwal($id, $status){
        $jadwal = dbeliModel::find($id);
        $jadwal->status = $status;
        $jadwal->save();
    }

    public function getHari($id){
        return dbeliModel::select("dbelipaket.hari","dbelipaket.tanggal")
                        ->where("idbeli","=",$id)
                        ->distinct()
                        ->get();
    }

    public function getCountCentang($idbeli){
        return dbeliModel::select("dbelipaket.*")
                        ->where("tanggal",'<=',NOW())
                        ->where('idbeli','=',$idbeli)
                        ->where('status','=',1)
                        ->get();
    }

    public function getCountSeharusnya($idbeli){
        return dbeliModel::select("dbelipaket.*")
                        ->where("tanggal","<=",NOW())
                        ->where("idbeli","=",$idbeli)
                        ->get();
    }
}
