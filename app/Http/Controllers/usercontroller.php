<?php
namespace App\Http\Controllers;

use App\ChatModel;
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
use App\TrackingBeratModel;
use Mail;
use Illuminate\Support\Facades\DB;

class usercontroller extends Controller
{

    public function dailycheckup() {
        $this->sendNotification(0,"Daily Checkup","Jangan Lupa Kontrol Trainee");
    }

    public function ingatMakanPagi(){
        $this->sendNotification(1,"Pengingat Makan Pagi","Jangan Lupa Makan Pagi");
    }

    public function ingatMakanSiang(){
        $this->sendNotification(1,"Pengingat Makan Siang","Jangan Lupa Makan Siang");
    }

    public function ingatMakanMalam(){
        $this->sendNotification(1,"Pengingat Makan Malam","Jangan Lupa Makan Malam");
    }

    public function olahraga(){
        $hsl = $this->sendNotification(1,"Pengingat Olahraga","Jangan Lupa Olahraga");

        return $hsl;
    }

    public function sendNotification($role, $title, $body){

        // $act = new actors();
        // $tkn = $act->find($username)->firebaseToken;

        //kalo lebih dari 1 user pake array token kalo cuman 1 orang pake token saja

        $model = new MemberModel();
        //konsultan
        if($role == 0){
            $list = $model->getListKonsultan();
        }
        else if($role == 1){
            $list = $model->getListMember();
        }

        $rtkn = [];

        for($i = 0; $i < count($list); $i++){
            if($list[$i]->fbkey != "" || $list[$i]->fbkey != null){
                array_push($rtkn,$list[$i]->fbkey);
                // $rtkn[$i] = $list[$i]->fbkey;
            }
        }

        // $tkn = "";
        // array_push($rtkn, $tkn);
        $ttt = "QUFBQXIxLW45eTg6QVBBOTFiR3djRUowUGNpd2xyRjdwMGo5RWl5ZzJnR2U2S3dFQ3RpcGhlUlJ5dnpBUl9UZDA0OER6NURwZlRla0RQZ2pqR2I0bHAwb3ZyanR5Nm13cVZWdzR5M2NSUGR5bmFTaTV3WEZlZlhsTklTUlB2NDJWZkNpdFRhVXNVX0pnMDE2UXUtMmtmV08=";

        $data = [
            "registration_ids" => $rtkn,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . base64_decode($ttt),
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        //dd($response);
        $res['status']=$rtkn;
        return json_encode($res);
    }

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
			$memberBaru->password = md5($request->password);
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
            $chatbaru = new ChatModel;
            $chatbaru->id = 0;
            $chatbaru->username1 = $memberBaru->id;
            $chatbaru->username2 = "11";
            $chatbaru->save();
            $chatbaru = new ChatModel;
            $chatbaru->id = 0;
            $chatbaru->username1 = "11";
            $chatbaru->username2 = $memberBaru->id;
            $chatbaru->save();


			$return[0]['status'] = "sukses";
		}
        // $return[0]['status'] = $request->username."-".$request->email."-".$request->nohp."-".$request->password."-".$request->konsultan."-".$request->jk;
		echo json_encode($return);
    }

    public function konfirmasiAkun($email){
        $model = new MemberModel();
        $hsl = $model->memberEmail($email);
        $hsl[0]->status = "Aktif";
        $hsl[0]->save();
        return view("selesai");
    }

    public function kirimEmailAktivasi(Request $req){
        $data['email'] = $req->email;
        Mail::send('konfirmasiakun', ['data'=> $data],
                    function($message) use ($req)
                    {
                        $message->subject("[AKTIVASI AKUN]");
                        $message->from("admin@dietyukyuk.com","Dietyuk App");
                        $message->to($req->email);
                    }
                );
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
				$message->from("admin@dietyukyuk.com","admin@dietyukyuk.com");
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
            $hasil[0]->password = md5($pass);
            $hasil[0]->save();
            $return[0]['pesan'] = "sukses";
        }
        else{
            $return[0]['pesan'] = "gagal";
        }
        echo json_encode($return);
    }

    public function getDataCustomer(Request $req){
        $model = new MemberModel();
        $hsl = $model->getDataCustomer($req->id);
        $return[0]['profile'] = $hsl;
        echo json_encode($return);
    }

	public function login(Request $req){
		$username = $req->username;
		$password = $req->password;
		$return = [];
		$model = new MemberModel();
		$hsl = $model->loginUser($username, md5($password));

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

    public function getHistoryBerat(Request $req){
        $tracking = new TrackingBeratModel();
        $return[0]['databeratbadan'] = $tracking->getHistoryBeratBadan($req->user);
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
