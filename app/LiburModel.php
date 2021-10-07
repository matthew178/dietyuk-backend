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
}
