<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MemberModel;
use Illuminate\Support\Facades\DB;

class PaketModel extends Model
{
    protected $table= 'paket';
    protected $primaryKey = 'id_paket';
    public $incrementing = false;
    protected $fillable= [
        'id_paket',
        'nama_paket',
        'jenispaket',
		'deskripsi',
		'estimasiturun',
		'harga',
		'durasi',
		'status',
		'rating',
		'konsultan',
		'waktutambah',
        'gambar'
    ];
    public $timestamps= false;

	public function getPaket(){
        return PaketModel::select('paket.*', "member.nama","jenispaket.background")
                        ->join('member','member.id',"=","paket.konsultan")
                        ->join('jenispaket','jenispaket.idjenispaket','=','paket.jenispaket')
                        ->where('paket.status','=',1)
                        ->get();
    }

	public function getPaketKonsultan($id){
        return PaketModel::select('paket.*', "member.nama","jenispaket.background" )
                    ->join('member','member.id',"=","paket.konsultan")
                    ->join('jenispaket','jenispaket.idjenispaket','=','paket.jenispaket')
                    ->where('konsultan','=',$id)
                    ->get();
    }

	public function getPaketById($id){
        return PaketModel::select('paket.*','jenispaket.background','member.username')
                        ->join('jenispaket','jenispaket.idjenispaket','=','paket.jenispaket')
                        ->join('member','member.id','=','paket.konsultan')
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

    public function searchPaketMember($cari){
        return PaketModel::select('paket.*', "member.nama","jenispaket.background")
                            ->join('member','member.id',"=","paket.konsultan")
                            ->join('jenispaket','jenispaket.idjenispaket','=','paket.jenispaket')
                            ->where("nama_paket","like", "%".strtoupper($cari)."%")
                            ->where('paket.status','=',1)
                            ->orWhere('member.nama',"like", "%".strtoupper($cari)."%")
                            ->where('paket.status','=',1)
                            ->get();
    }

    public function searchPaketKonsultan($cari,$konsultan){
        return PaketModel::select('paket.*', "member.nama","jenispaket.background")
                            ->join('member','member.id',"=","paket.konsultan")
                            ->join('jenispaket','jenispaket.idjenispaket','=','paket.jenispaket')
                            ->where("nama_paket","like", "%".strtoupper($cari)."%")
                            ->where('paket.status','=',1)
                            ->where('paket.konsultan','=',$konsultan)
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

    public function getLaporanPaket($konsultan){
        return PaketModel::select('paket.id_paket',DB::raw('count(*) as jumlah'))
                            ->join('hbelipaket','hbelipaket.idpaket','=','paket.id_paket')
                            ->where('paket.konsultan','=',$konsultan)
                            ->groupBy('paket.id_paket')
                            ->get();
    }

    public function getDetailLaporanPaket($konsultan,$bulan,$tahun){
        return PaketModel::select('paket.id_paket',DB::raw('count(*) as jumlah'))
                            ->join('hbelipaket','hbelipaket.idpaket','=','paket.id_paket')
                            ->where('paket.konsultan','=',$konsultan)
                            ->whereMonth('hbelipaket.tanggalbeli','=',$bulan)
                            ->whereYear('hbelipaket.tanggalbeli','=',$tahun)
                            ->groupBy('paket.id_paket')
                            ->get();
    }

    public function getLaporanPaketTerfav($konsultan){
        return PaketModel::select('paket.id_paket',DB::raw('count(*) as jumlah'))
                            ->join('hbelipaket','hbelipaket.idpaket','=','paket.id_paket')
                            ->where('paket.konsultan','=',$konsultan)
                            ->groupBy('paket.id_paket')
                            ->orderBy('jumlah','DESC')
                            ->get();
    }

    public function getLapPaketRating($konsultan){
        return PaketModel::select('paket.id_paket','paket.rating')
                            ->where('paket.konsultan','=',$konsultan)
                            ->orderBy('paket.rating','DESC')
                            ->get();
    }

    public function getSemuaPaketKonsultan($id){
        return PaketModel::select('paket.*', "member.nama","jenispaket.background" )
                       ->join('member','member.id',"=","paket.konsultan")
                       ->join('jenispaket','jenispaket.idjenispaket','=','paket.jenispaket')
                       ->where('konsultan','=',$id)
                       ->get();
   }
}
