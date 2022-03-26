<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingBeratModel extends Model
{
    protected $table= 'trackingberat';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'username',
        'tanggal',
        'berat',
        'keterangan'
    ];
    public $timestamps= false;

    public function getHistoryBeratBadan($username){
        return TrackingBeratModel::select("trackingberat.*")
                                ->where("username","=",$username)
                                ->get();
    }
}
