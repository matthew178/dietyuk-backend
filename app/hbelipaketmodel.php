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
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","0")
                                ->get();
    }

    public function onProses($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","1")
                                ->get();
    }

    public function getTransaksiSelesai($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","2")
                                ->get();
    }

    public function getTransaksiBatal($user){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("hbelipaket.iduser","=",$user)
                                ->where("hbelipaket.status","=","3")
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
}
