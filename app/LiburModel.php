<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiburModel extends Model
{
    protected $table= 'liburkonsultan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id','konsultan','tanggalawal','tanggalakhir','status'
    ];
    public $timestamps= false;

    public function cariLibur($konsultan){
        return LiburModel::select("liburkonsultan.*")
                        ->where("status","=","0")
                        ->where("konsultan","=",$konsultan)
                        ->get();
    }

    public function getBelumLiburKonsultan(){
        return LiburModel::select("liburkonsultan.*")
                        ->where("status","=","0")
                        ->where("tanggalawal","<=",date("Y-m-d"))
                        ->get();
    }

    public function getAllLiburKonsultan(){
        return LiburModel::select("liburkonsultan.*")
                        ->where("status","=","1")
                        ->where("tanggalakhir","<=",date("Y-m-d"))
                        ->get();
    }
}
