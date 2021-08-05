<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KategoriModel;
use App\JenisPaketModel;
use App\MemberModel;
use App\PaketModel;

class admincontroller extends Controller
{
    public function login(Request $req){
        $uname = $req->uname;
        $pass = $req->password;
        $member = new MemberModel();
        $hsl = $member->loginUser($uname,$pass);
        // echo $hsl[0]['jeniskelamin'];
        if(count($hsl) > 0){
            if($hsl[0]['role'] == "admin"){
                return view("dashboard");
            }
            else{
                return view("index");
            }
        }
        else{
            return view("index");
        }
	}

    public function jenispaket(){
        $jenis = JenisPaketModel::all();
        return view("masterjenispaket",["jenis" => $jenis]);
    }

    public function jenisproduk(){
        $model = KategoriModel::all();
        return view("masterjenisproduk",["kategori" => $model]);
    }

    public function tambahjenisproduk(Request $req){
        $model = KategoriModel::all();
        $jum = count($model)+1;
        $kode = "KA";
        $kategoriBaru = new KategoriModel();
        $nama = $req->jenis;
        if($jum < 10){
            $kode = $kode."00".$jum;
        }
        else if($jum > 10 && $jum < 100){
            $kode = $kode."0".$jum;
        }
        else{
            $kode = $kode.$jum;
        }
        $kategoriBaru->kodekategori = $kode;
        $kategoriBaru->namakategori = $nama;
        $kategoriBaru->save();

        return redirect("/jenisproduk");
    }

    public function tambahjenispaket(Request $req){
        $model = JenisPaketModel::all();
        $jum = count($model)+1;
        $kode = "JP";
        $jenisBaru = new JenisPaketModel();
        $nama = $req->namajenis;
        if($jum < 10){
            $kode = $kode."00".$jum;
        }
        else if($jum > 10 && $jum < 100){
            $kode = $kode."0".$jum;
        }
        else{
            $kode = $kode.$jum;
        }
        $jenisBaru->idjenispaket = $kode;
        $jenisBaru->namajenispaket = $nama;
        $jenisBaru->deskripsijenis = $req->deskripsi;
        $jenisBaru->save();
        return redirect("/jenispaket");
    }

    public function confirmkonsultan(){
        $model = new MemberModel();
        $member = $model->getKonsultan();
        return view("confirmkonsultan",["member" => $member]);
    }

    public function confirmsaldo(){
        return view("confirmsaldo");
    }

    public function mastermember(){
        return view("mastermember",["member" => MemberModel::all()]);
    }

    public function masterpaket(){
        $model = new PaketModel;
		$paket = $model->getPaket();
        return view("masterpaket",["paket" => $paket]);
    }

    public function searchPaket(Request $req){
        $cari = $req->cari;
        if($cari != ""){
            $model = new PaketModel();
            $hsl = $model->searchPaket($cari);
        }
        else{
            $hsl = PaketModel::all();
        }
        return view("masterpaket",["paket" => $hsl]);
    }

    public function searchMember(Request $req){
        $cari = $req->cari;
        if($cari != ""){
            $model = new MemberModel();
            $hsl = $model->searchMember($cari);
        }
        else{
            $hsl = MemberModel::all();
        }
        return view("mastermember",["member" => $hsl]);
    }

    public function detail($username){
        $model = new MemberModel();
        $member = $model->getBiodata($username);
        return view("detailkonsultan",["member" => $member]);
    }

    public function terimakonsultan(Request $req){
        $konsul = $req->username;
        $member = new MemberModel();
        $hsl = $member->terimaKonsultan($konsul);
        $model = new MemberModel();
        $member = $model->getKonsultan();
        return view("confirmkonsultan",["member" => $member]);
    }

    public function tolakkonsultan(Request $req){
        $konsul = $req->username;
        $member = new MemberModel();
        $hsl = $member->tolakKonsultan($konsul);
        $model = new MemberModel();
        $member = $model->getKonsultan();
        return view("confirmkonsultan",["member" => $member]);
    }

    public function blockuser($id){
        $model = new MemberModel();
        $user = $model->blockUser($id);
        return view("mastermember",["member"=>MemberModel::all()]);
    }

    public function aktifkanuser($id){
        $model = new MemberModel();
        $user = $model->aktifkanUser($id);
        return view("mastermember",["member"=>MemberModel::all()]);
    }

    public function blockpaket($id){
        $model = new PaketModel();
        $paket = $model->blockPaket($id);
        $pakets = $model->getPaket();
        return view("masterpaket",["paket"=>$pakets]);
    }

    public function aktifkanpaket($id){
        $model = new PaketModel();
        $paket = $model->aktifkanPaket($id);
        $pakets = $model->getPaket();
        return view("masterpaket",["paket"=>$pakets]);
    }
}