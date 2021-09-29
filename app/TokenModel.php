<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    protected $table= 'token';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'token',
        'email',
        'expire'
    ];
    public $timestamps= false;

    public function getToken($otp, $email){
        $skrg = date('Y-m-d H:i:s');
        return TokenModel::select('token.*')
                        ->where("token","=",$otp)
                        ->where("email","=",$email)
                        ->where("expire",">",$skrg)
                        ->get();
    }
}
