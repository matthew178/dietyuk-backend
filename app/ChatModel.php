<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
    protected $table= 'chat';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'username1',
		'username2'
    ];
    public $timestamps= false;

    public function cekUsernamePesan($uname1, $uname2){
        return ChatModel::select("chat.*")
                         ->where('username1','=',$uname1)
                         ->where('username2','=',$uname2)
                         ->orWhere('username1','=',$uname1)
                         ->where('username2','=',$uname2)
                         ->get();
    }

    public function getListChatUser($uname){
        return ChatModel::select('chat.id','chat.username2','member.username','member.nama','member.foto')
                        ->join('member','chat.username2','=','member.id')
                        ->where('chat.username1','=',$uname)
                        ->get();
    }
}
