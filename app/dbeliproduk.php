<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dbeliproduk extends Model
{
    protected $table= 'dbeliproduk';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'idbeli',
        'idproduk',
		'jumlah',
		'harga',
		'subtotal'
    ];
    public $timestamps= false;

    public function getDetail($id){
        return dbeliproduk::select("dbeliproduk.*","produk.namaproduk","produk.varian","produk.foto")
                          ->join("produk","produk.kodeproduk","=","dbeliproduk.idproduk")
                          ->where("dbeliproduk.idbeli","=",$id)
                          ->first();
    }

    public function countDetail($id){
        return dbeliproduk::select("dbeliproduk.*","produk.namaproduk","produk.varian","produk.foto")
                          ->join("produk","produk.kodeproduk","=","dbeliproduk.idproduk")
                          ->where("dbeliproduk.idbeli","=",$id)
                          ->get();
    }
}
