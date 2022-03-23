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
        'status',
        'berat'
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

    public function searchProduk($cari,$id){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->Where("namaproduk",'like','%'.$cari.'%')
                        ->where('kodekategori','=',$id)
                        ->orWhere("varian",'like','%'.$cari.'%')
                        ->where('kodekategori','=',$id)
                        ->get();
    }

    public function searchProduk1($cari,$id){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->Where("namaproduk",'like','%'.$cari.'%')
                        ->orWhere("varian",'like','%'.$cari.'%')
                        ->get();
    }

    public function searchProdukKonsultan($cari,$konsultan){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->Where("namaproduk",'like','%'.$cari.'%')
                        ->where('produk.konsultan','=',$konsultan)
                        ->orWhere("varian",'like','%'.$cari.'%')
                        ->where('produk.konsultan','=',$konsultan)
                        ->get();
    }

    public function getProdukDetail($id){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
						->where('kodeproduk','=',$id)
                        ->first();
    }

    public function searchFilterProduk($cari,$id,$hawal, $hakhir){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->Where("namaproduk",'like','%'.$cari.'%')
                        ->where('kodekategori','=',$id)
                        ->where('produk.harga',">=",$hawal)
                        ->where('produk.harga',"<=",$hakhir)
                        ->orWhere("varian",'like','%'.$cari.'%')
                        ->where('kodekategori','=',$id)
                        ->where('produk.harga',">=",$hawal)
                        ->where('produk.harga',"<=",$hakhir)
                        ->get();
    }

    public function searchFilterProduk1($cari,$id,$hawal, $hakhir){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->Where("namaproduk",'like','%'.$cari.'%')
                        ->where('produk.harga',">=",$hawal)
                        ->where('produk.harga',"<=",$hakhir)
                        ->orWhere("varian",'like','%'.$cari.'%')
                        ->where('produk.harga',">=",$hawal)
                        ->where('produk.harga',"<=",$hakhir)
                        ->get();
    }

    public function filterProduk($id,$hawal, $hakhir){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->where('kodekategori','=',$id)
                        ->where('produk.harga',">=",$hawal)
                        ->where('produk.harga',"<=",$hakhir)
                        ->orWhere('kodekategori','=',$id)
                        ->where('produk.harga',">=",$hawal)
                        ->where('produk.harga',"<=",$hakhir)
                        ->get();
    }

    public function filterProduk1($id,$hawal, $hakhir){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->where('produk.harga',">=",$hawal)
                        ->where('produk.harga',"<=",$hakhir)
                        ->orwhere('produk.harga',">=",$hawal)
                        ->where('produk.harga',"<=",$hakhir)
                        ->get();
    }

    public function filterawal($id,$hawal){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->where('kodekategori','=',$id)
                        ->where('produk.harga',">=",$hawal)
                        ->orWhere('kodekategori','=',$id)
                        ->where('produk.harga',">=",$hawal)
                        ->get();
    }

    public function filterakhir($id, $hakhir){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->where('kodekategori','=',$id)
                        ->where('produk.harga',"<=",$hakhir)
                        ->orWhere('kodekategori','=',$id)
                        ->where('produk.harga',"<=",$hakhir)
                        ->get();
    }

    public function filterawal1($id,$hawal){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->where('produk.harga',">=",$hawal)
                        ->orwhere('produk.harga',">=",$hawal)
                        ->get();
    }

    public function filterakhir1($id, $hakhir){
        return ProdukModel::select('produk.*','member.nama as namakonsultan','member.foto as fotokonsultan')
                         ->join('member','member.id',"=","produk.konsultan")
                        ->where('produk.harga',"<=",$hakhir)
                        ->orwhere('produk.harga',"<=",$hakhir)
                        ->get();
    }
}
