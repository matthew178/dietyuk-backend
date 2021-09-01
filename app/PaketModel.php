<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MemberModel;

class PaketModel extends Model
{
    protected $table= 'paket';
    protected $primaryKey = 'id_paket';
    public $incrementing = false;
    protected $fillable= [
        'id_paket',
        'nama',
		'deskripsi',
		'estimasiturun',
		'harga',
		'durasi',
		'status',
		'rating',
		'konsultan',
		'waktutambah'
    ];
    public $timestamps= false;

	public function getPaket(){
        return PaketModel::select('paket.*', "member.nama","jenispaket.background")
                        ->join('member','member.id',"=","paket.konsultan")
                        ->join('jenispaket','jenispaket.idjenispaket','=','paket.jenispaket')
                        ->get();
    }

	public function getPaketKonsultan($id){
         return PaketModel::select('paket.*')
                        ->where('konsultan','=',$id)
                        ->get();
    }

	public function getPaketById($id){
        return PaketModel::select('paket.*','jenispaket.background')
                        ->join('jenispaket','jenispaket.idjenispaket','=','paket.jenispaket')
						->where('id_paket','=',$id)
                        ->get();
    }

	public function updatePaket($id, $nama, $deskripsi, $estimasi, $harga, $durasi){
        $paket = PaketModel::find($id);
        $paket->nama_paket = $nama;
		$paket->deskripsi = $deskripsi;
		$paket->estimasiturun = $estimasi;
		$paket->harga = $harga;
		$paket->durasi = $durasi;
        $paket->save();
    }

    public function searchPaket($cari){
        return PaketModel::select("paket.*")
                            ->where("nama_paket","like", "%".strtoupper($cari)."%")
                            ->get();
    }

    public function blockPaket($id){
        $paket = PaketModel::find($id);
        $paket->status = 2;
        $paket->save();
    }

    public function aktifkanPaket($id){
        $paket = PaketModel::find($id);
        $paket->status = 1;
        $paket->save();
    }
}
