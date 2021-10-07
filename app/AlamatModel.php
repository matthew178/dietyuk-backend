<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlamatModel extends Model
{
    protected $table= 'alamat';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id','username','provinsi','kota','alamat_detail','penerima','nomortelepon'
    ];
    public $timestamps= false;

    public function getAlamatUser($id){
        return AlamatModel::select("alamat.*","kota.nama_kota as nama_kota","kota.provinsi as nama_provinsi")
                            ->join("kota","kota.id_kota","=","alamat.kota")
                            ->where("alamat.username","=",$id)
                            ->get();
    }
}
