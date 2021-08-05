<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class laporanperkembangan extends Model
{
    protected $table= 'laporanperkembangan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'idbeli',
		'username',
		'berat',
		'status',
        'harike',
    ];
    public $timestamps= false;

    public function getLaporanById($id){
        return laporanperkembangan::select('laporanperkembangan.*')
                       ->where('idbeli','=',$id)
                       ->get();
   }
}
