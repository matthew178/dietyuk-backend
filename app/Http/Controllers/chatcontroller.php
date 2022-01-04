<?php

namespace App\Http\Controllers;

use App\ChatModel;
use Illuminate\Http\Request;

class chatcontroller extends Controller
{
    public function cekPesan(Request $req){
        $model = new ChatModel();
        $hsl = $model->cekUsernamePesan($req->username1, $req->username2);
        if(count($hsl) == 0){
            $chatbaru = new ChatModel;
            $chatbaru->id = 0;
            $chatbaru->username1 = $req->username1;
            $chatbaru->username2 = $req->username2;
            $chatbaru->save();
            $chatbaru = new ChatModel;
            $chatbaru->id = 0;
            $chatbaru->username1 = $req->username2;
            $chatbaru->username2 = $req->username1;
            $chatbaru->save();
            $status = "selesai";
        }
        else{
            $status = "gagal";
        }
        $return[0]['status'] = $status;
        echo json_encode($return);
    }

    public function getListChatUser(Request $req){
        $model = new ChatModel();
        $hsl = $model->getListChatUser($req->username);
        $return[0]['listchat'] = $hsl;
        echo json_encode($return);
    }
}
