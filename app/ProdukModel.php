<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukModel extends Model
{
    protected $table= 'produk';
    protected $primaryKey = 'kodeproduk';
    public $incrementing = false;
    protected $fillable= [
        'kodeproduk',
        'konsultan',
        'namaproduk',
        'kodekategori',
        'kemasan',
        'harga',
        'foto',
        'deskripsi',
        'status'
    ];
    public $timestamps= false;

    public function getProdukByKonsultan($id){
        return ProdukModel::select('produk.*')
						->where('konsultan','=',$id)
                        ->get();
    }

    public function getProdukByKategori($id){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
						->where('kodekategori','=',$id)
                        ->get();
    }

    public function searchProduk($cari){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
						->where('namaproduk','=',$cari)
                        ->orWhere('varian','=',$cari)
                        ->get();
    }

    public function getProdukDetail($id){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
						->where('kodeproduk','=',$id)
                        ->get();
    }
}