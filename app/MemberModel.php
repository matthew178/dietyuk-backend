<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MemberModel extends Model
{
    protected $table= 'member';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'username',
        'email',
        'password',
        'nama',
		'jeniskelamin',
		'nomorhp',
		'tanggallahir',
		'berat',
		'tinggi',
		'role',
		'saldo',
		'rating',
		'status',
		'foto',
        'waktudaftar',
        'provinsi',
        'kota',
        'fbkey'
    ];
    public $timestamps= false;

	public function loginUser($email,$password){
        return MemberModel::select('member.*')
                        ->where('email','=',$email)
                        ->where('password','=',$password)
                        ->orWhere('username','=',$email)
                        ->where('password','=',$password)
                        ->get();
    }

    public function getListKonsultan(){
        return MemberModel::select("member.*")
                        ->where('role','=','konsultan')
                        ->get();
    }

    public function getListMember(){
        return MemberModel::select("member.*")
                        ->where('role','=','member')
                        ->get();
    }

	public function getProfile($id){
        return MemberModel::select('member.*')
                        ->where('id','=',$id)
                        ->get();
    }

    public function getMemberTanpaAdmin(){
        return MemberModel::select('member.*')
                        ->where('role','!=','admin')
                        ->get();
    }

    public function getCountKonsultan(){
        return MemberModel::select('member.username', DB::raw('count(*) as jumlah'))
                            ->join('paket','paket.konsultan','=','member.id')
                            ->join('hbelipaket','hbelipaket.idpaket','=','paket.id_paket')
                            ->groupBy('member.username')
                            ->orderBy("jumlah",'DESC')
                            ->get();
    }

    public function getDataCustomer($id){
        return MemberModel::select('member.*')
                        ->join('hbelipaket','hbelipaket.iduser','=','member.id')
                        ->where('hbelipaket.id','=',$id)
                        ->get();
    }

    public function memberEmail($email){
        return MemberModel::select('member.*')
                        ->where('email','=',$email)
                        ->get();
    }

	public function updateMember($id, $nama, $username, $email, $nohp, $berat, $tinggi, $file,$prov, $city){
        $member = MemberModel::find($id);
        $member->nama = $nama;
        $member->email = $email;
        $member->username = $username;
        $member->nomorhp = $nohp;
        $member->tinggi = $tinggi;
        $member->kota = $city;
        $member->provinsi = $prov;
        if(intval($member->berat) != intval($berat)){
            $tracking = new TrackingBeratModel();
            $tracking->username = $id;
            $tracking->tanggal = NOW();
            $tracking->berat = $berat;
            $tracking->keterangan = "Update profile";
            $tracking->save();
            echo "masuk";
        }
        $member->berat = $berat;
        if($file != ""){
            $member->foto = $file;
        }
        echo "sampe sini";
        $member->save();
    }

    public function searchMember($cari){
        return MemberModel::select("member.*")
                            ->where("username",'=',$cari)
                            ->orWhere("email",'=',$cari)
                            ->orWhere("nomorhp",'=',$cari)
                            ->orWhere("nama",'like','%'.$cari.'%')
                            ->get();
    }

    public function searchTransaksiUntukLibur($id,$awal,$akhir){
        return hbelipaketmodel::select("hbelipaket.*", "paket.nama_paket", "member.nama")
                                ->join("paket","paket.id_paket","=","hbelipaket.idpaket")
                                ->join("member","member.id","=","paket.konsultan")
                                ->where("paket.konsultan","=",$id)
                                ->whereBetween('hbelipaket.tanggalaktifasi',[$awal,$akhir])
                                ->orwhereBetween('hbelipaket.tanggalselesai',[$awal,$akhir])
                                ->where("paket.konsultan","=",$id)
                                ->orwhere("paket.konsultan","=",$id)
                                ->where('hbelipaket.tanggalaktifasi',"<",$awal)
                                ->where('hbelipaket.tanggalselesai',">",$awal)
                                ->where("paket.konsultan","=",$id)
                                ->where('hbelipaket.tanggalaktifasi',"<",$akhir)
                                ->where('hbelipaket.tanggalselesai',">",$akhir)
                                ->get();

    }

    public function getKonsultan(){
        return MemberModel::select("member.*")
                            ->where("role","=","konsultan")
                            ->where("status","=","Pending")
                            ->get();
    }

    public function getBiodata($id){
        return MemberModel::select('member.*')
                        ->where('username','=',$id)
                        ->get();
    }

    public function terimaKonsultan($id){
        $member = MemberModel::find($id);
        $member->status = "Aktif";
        $member->save();
    }

    public function tolakKonsultan($id){
        $member = MemberModel::find($id);
        $member->status = "Pending";
        $member->save();
    }

    public function blockUser($id){
        $member = MemberModel::find($id);
        $member->status = "Tidak Aktif";
        $member->save();
    }

    public function aktifkanUser($id){
        $member = MemberModel::find($id);
        $member->status = "Aktif";
        $member->save();
    }
}
