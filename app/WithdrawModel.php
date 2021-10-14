<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawModel extends Model
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

    public function getHistoryWithdraw($uname){
        return WithdrawModel::select('withdraw.*')
                        ->where("withdraw.id_user","=",$uname)
                        ->get();
    }
}
