<?php
namespace App\Http\Controllers;

use App\LiburModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\MemberModel;
use App\TokenModel;
use Mail;

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
			$memberBaru->nama = "";
			$memberBaru->email = $request->email;
			$memberBaru->nomorhp = $request->nohp;
			$memberBaru->password = $request->password;
			$memberBaru->saldo = 0;
			$memberBaru->rating = 0;
			$memberBaru->berat = 0;
			$memberBaru->tinggi = 0;
            $memberBaru->provinsi = 0;
            $memberBaru->kota = 0;
            $memberBaru->waktudaftar = NOW();
			if($request->konsultan == true){
				$memberBaru->role = "konsultan";
				$memberBaru->status = "Pending";
			}
			else{
				$memberBaru->role = "member";
				$memberBaru->status = "Pending";
                $data['email'] = $request->email;
                Mail::send('konfirmasiakun', ['data'=> $data],
                    function($message) use ($request)
                    {
                        $message->subject("Konfirmasi Akun");
                        $message->from("hendrymatthew97@gmail.com","hendrymatthew97@gmail.com");
                        $message->to($request->email);
                    }
                );
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

    public function konfirmasiAkun(Request $req){
        $model = new MemberModel();
        $hsl = $model->memberEmail($req->email);
        $hsl[0]->status = "Aktif";
        $hsl[0]->save();
    }

	public function kirimEmailVerifikasi(Request $req){
		$kodeotp = Str::random(5);
		$token = new TokenModel();
		$token->id = 0;
		$token->token = $kodeotp;
		$token->email = $req->email;
		$token->expire = Carbon::now()->addMinutes(5);
		$token->save();
		$data['kodeotp'] = $kodeotp;
		Mail::send('emailverifikasi', ['data'=> $data],
			function($message) use ($req)
			{
				$message->subject("[KODE VERIFIKASI]");
				$message->from("hendrymatthew97@gmail.com","hendrymatthew97@gmail.com");
				$message->to($req->email);
			}
		);
	}

    public function resetPass(Request $req){
        $return = [];
        $kodeotp = $req->otp;
        $pass = $req->pass;
        $user = $req->email;
        $model = new TokenModel();
        $hsl = $model->getToken($kodeotp, $user);
        if(count($hsl) > 0){
            $member = new MemberModel();
            $hasil = $member->memberEmail($user);
            $hasil[0]->password = $pass;
            $hasil[0]->save();
            $return[0]['pesan'] = "sukses";
        }
        else{
            $return[0]['pesan'] = "gagal";
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
            $hsl[0]->fbkey = $req->token;
            $hsl[0]->save();
			$return[0]['pesan'] = "sukses";
			$return[0]['id'] = $hsl[0]->id;
            $return[0]['status'] = $hsl[0]->status;
			$return[0]['role'] = $hsl[0]->role;
		}
		else{
			$return[0]['pesan'] = "gagal";
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
        $kota = $req->city;
        $provinsi = $req->prov;
        if($req->m_filename != ""){
            $datagambar = base64_decode($req->m_image);
            file_put_contents("gambar/".$namafile, $datagambar);
        }
		$model->updateMember($id, $nama, $username, $email, $nohp, $berat, $tinggi, $namafile,$provinsi,$kota);
	}

    public function hitungOngkir(Request $req){
        $arr['jne'] = $this->getOngkirKurir($req->asal,$req->tujuan,$req->berat,"jne");
        $arr['pos'] = $this->getOngkirKurir($req->asal,$req->tujuan,$req->berat,"pos");
        $arr['tiki'] = $this->getOngkirKurir($req->asal,$req->tujuan,$req->berat,"tiki");

        echo json_encode($arr);
    }

    public function getOngkirKurir($asal, $tujuan, $berat, $kurir){
        $asal = MemberModel::find($asal);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$asal->kota."&destination=".$tujuan."&weight=".$berat."&courier=".$kurir,
        CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: 528375533b45735afc2e5eb260d6502e"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return $response;
    }

    public function tambahLibur(Request $req){
        $model = new MemberModel();
        $hsl = $model->searchTransaksiUntukLibur($req->id,$req->awal,$req->akhir);
        if(count($hsl) > 0){
            $return[0]['status'] = "Terdapat jadwal konsultasi dalam periode tanggal tersebut.";
        }
        else{
            $cari = new LiburModel();
            $hsl = $cari->cariLibur($req->id);
            if(count($hsl) > 0){
                $return[0]['status'] = "Konsultan masih memiliki jadwal libur pada tanggal ".$hsl[0]->tanggalawal." sampai dengan tanggal ".$hsl[0]->tanggalakhir;
            }
            else{
                $libur = new LiburModel();
                $libur->id = 0;
                $libur->konsultan = $req->id;
                $libur->tanggalawal = $req->awal;
                $libur->tanggalakhir = $req->akhir;
                $libur->status = 0;
                $libur->save();
                $return[0]['status'] = "Berhasil tambah libur";
            }
        }
        echo json_encode($return);
    }

    public function getKota(Request $req){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$req->province,
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
