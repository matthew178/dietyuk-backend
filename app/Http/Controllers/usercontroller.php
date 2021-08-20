<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\MemberModel;

class usercontroller extends Controller
{
	public function register(Request $request){
		$member = MemberModel::all();
		$ada = false;
		$return = [];
		for($i=0;$i<count($member);$i++){
			if($member[$i]->username == $request->username || $member[$i]->email == $request->email){
				$ada = true;
			}
		}
		if($ada == true){
			$return[0]['status'] = "gagal";
		}
		else{
			$memberBaru = new MemberModel;
			$memberBaru->username = $request->username;
			$memberBaru->nama = $request->nama;
			$memberBaru->email = $request->email;
			$memberBaru->nomorhp = $request->nohp;
			$memberBaru->password = $request->password;
			$memberBaru->saldo = 0;
			$memberBaru->rating = 0;
			$memberBaru->berat = 0;
			$memberBaru->tinggi = 0;
            $memberBaru->waktudaftar = NOW();
			if($request->konsultan == true){
				$memberBaru->role = "konsultan";
				$memberBaru->status = "Pending";
			}
			else{
				$memberBaru->role = "member";
				$memberBaru->status = "Aktif";
			}
			if($request->jk == "pria"){
				$memberBaru->jeniskelamin = "pria";
				$memberBaru->foto = "pria.png";
			}
			else{
				$memberBaru->jeniskelamin = "wanita";
				$memberBaru->foto = "wanita.png";
			}
			$memberBaru->save();

			$return[0]['status'] = "sukses";
		}
		echo json_encode($return);
    }

	public function login(Request $req){
		$username = $req->username;
		$password = $req->password;
		$return = [];
		$model = new MemberModel();
		$hsl = $model->loginUser($username, $password);
		if(count($hsl) > 0){
			$return[0]['status'] = "sukses";
			$return[0]['id'] = $hsl[0]->id;
			$return[0]['role'] = $hsl[0]->role;
		}
		else{
			$return[0]['status'] = "gagal";
		}
		echo json_encode($return);
	}

	/*public function tambahfoto(Request $req){
		$namafile = $req->m_filename;
		$datagambar = base64_decode($req->m_image);
		file_put_contents("gambar/".$namafile, $datagambar);

		$return[0]['status'] = "sukses upload foto";
		echo json_encode($return);
	}*/

	public function getProfile(Request $req){
		$id = $req->id;
		$model = new MemberModel();
		$hsl = $model->getProfile($id);
		$return[0]['profile'] = $hsl;

		echo json_encode($return);

	}

	public function updateProfile(Request $req){
		$model = new MemberModel();
		$id = $req->id;
		$nama = $req->nama;
		$email = $req->email;
		$username = $req->username;
		$nohp = $req->nomorhp;
		$berat = $req->berat;
		$tinggi = $req->tinggi;
		$namafile = $req->m_filename;
        if($req->m_filename != ""){
            $datagambar = base64_decode($req->m_image);
            file_put_contents("gambar/".$namafile, $datagambar);
        }
		$model->updateMember($id, $nama, $username, $email, $nohp, $berat, $tinggi, $namafile);
	}

    public function hitungOngkir(Request $req){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$req->asal."&destination=".$req->tujuan."&weight=".$req->berat."&courier=".$req->kurir,
        CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: 528375533b45735afc2e5eb260d6502e"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        echo $response;
    }

    public function getKota(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "key: 528375533b45735afc2e5eb260d6502e"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

		echo $response;
    }

    public function getProvinsi(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "key: 528375533b45735afc2e5eb260d6502e"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        echo $response;
    }
}
