<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenarikanModel extends Model
{
    protected $table= 'withdraw';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'id_user',
        'saldo',
        'status',
        'waktu',
        'nomorrekening',
        'bank',
        'atasnama'
    ];
    public $timestamps= false;

    public function getSaldoBelumConfirm(){
        return PenarikanModel::select('withdraw.*','member.username')
                        ->join('member','member.id','=','withdraw.id_user')
                        ->where("withdraw.status","=","0")
                        ->get();
    }

    public function konfirmasiPenarikan($id){
        $saldo = PenarikanModel::find($id);
        if($saldo->status == 0){
            $saldo->status = 1;
            $saldo->save();
        }
    }
}
