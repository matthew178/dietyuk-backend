<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class hbelipaketmodel extends Model
{
    protected $table= 'hbelipaket';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'idpaket',
		'iduser',
		'tanggalbeli',
		'tanggalaktifasi',
        'tanggalselesai',
        'keterangan',
        'durasi',
        'totalharga',
        'status'
    ];
    public $timestamps= false;

    public function getTransaksiBelumAktif($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama","member.status as statuskonsultan")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","0")
                                ->get();
    }

    public function getBeliKonsultan($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama","member.status as statuskonsultan")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","hbelipaket.iduser")
                                ->where("paket.konsultan","=",$user)
                                ->where("hbelipaket.status","=","1")
                                ->get();
    }

    public function getSelesaiKonsultan($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama","member.status as statuskonsultan")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","hbelipaket.iduser")
                                ->where("paket.konsultan","=",$user)
                                ->where("hbelipaket.status","=","2")
                                ->orwhere("paket.konsultan","=",$user)
                                ->where("hbelipaket.status","=","5")
                                ->get();
    }

    public function onProses($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama","member.status as statuskonsultan")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","1")
                                ->get();
    }

    public function getTransaksiSelesai($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama", "member.status as statuskonsultan")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","2")
                                ->orwhere("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","5")
                                ->get();
    }

    public function getTransaksiBatal($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama", "member.status as statuskonsultan")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","3")
                                ->orWhere("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","4")
                                ->get();
    }

    public function getAllTransaksiOnGoing(){
        return hbelipaketmodel::select("hbelipaket.*")
                                ->where('status','=',1)
                                ->get();
    }

    public function getTransaksiPaketKonsultan($id){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama", "member.status as statuskonsultan")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("member.id","=",$id)
                                ->where("hbelipaket.status","=",1)
                                ->get();
    }

    public function aktivasiPaket($id){
        $paket = hbelipaketmodel::find($id);
        $hariini = Carbon::now();
        $paket->tanggalaktifasi = NOW();
        $paket->tanggalselesai = $hariini->addDays($paket->durasi);
        $paket->status = 1;
        $paket->save();
    }

    public function getdetailtransaksibulan($year, $month){
        return hbelipaketmodel::select("paket.nama_paket","member.username","hbelipaket.*")
                                    ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                    ->join("member","member.id","=","hbelipaket.iduser")
                                    ->whereYear("hbelipaket.tanggalbeli" , $year)
                                    ->whereMonth("hbelipaket.tanggalbeli", $month)
                                    ->orderby("tanggalbeli","asc")
                                    ->get();
    }
}
