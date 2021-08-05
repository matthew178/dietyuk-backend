<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalModel extends Model
{
    protected $table= 'jadwalpaket';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'id_paket',
		'hari',
		'waktu',
		'keterangan',
        'takaran'
    ];
    public $timestamps= false;

	public function getJadwalById($id){
         return JadwalModel::select('jadwalpaket.*')
                        ->where('id_paket','=',$id)
                        ->orderBy('hari','ASC')
                        ->get();
    }

}
