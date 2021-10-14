<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldoModel extends Model
{
    protected $table= 'topup';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'id_user',
        'saldo',
        'status',
        'waktu',
        'bank',
        'buktitransfer'
    ];
    public $timestamps= false;

    public function getSaldoBelumConfirm(){
        return SaldoModel::select('topup.*','member.username')
                        ->join('member','member.id','=','topup.id_user')
                        ->where("topup.status","=","0")
                        ->get();
    }

    public function getHistory($uname){
        return SaldoModel::select('topup.*')
                        ->where("topup.id_user","=",$uname)
                        ->get();
    }

    public function konfirmasisaldo($id){
        $saldo = SaldoModel::find($id);
        if($saldo->status == 0){
            $saldo->status = 1;
            $saldo->save();
            $member = MemberModel::find($saldo->id_user);
            $member->saldo = $member->saldo + $saldo->saldo;
            $member->save();
        }
    }
}
