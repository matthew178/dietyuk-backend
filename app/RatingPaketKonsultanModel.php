<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingPaketKonsultanModel extends Model
{
    protected $table= 'review_paket';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'idbeli',
        'konsultan',
        'paket',
        'ratingpaket',
        'ratingkonsultan',
        'review_paket',
        'review_konsultan',
        'testimoni'
    ];
    public $timestamps= false;

    public function getReviewPaket($id){
        return RatingPaketKonsultanModel::select('review_paket.*','member.username')
                                            ->join('hbelipaket','hbelipaket.id','=','review_paket.idbeli')
                                            ->join('member','member.id','=','hbelipaket.iduser')
                                            ->where('hbelipaket.idpaket','=',$id)
                                            ->get();
    }

    public function getRatingKonsultan($id){
        return RatingPaketKonsultanModel::select('review_paket.*')
                                            ->where('konsultan','=',$id)
                                            ->get();
    }

    public function getRatingPaket($id){
        return RatingPaketKonsultanModel::select('review_paket.*')
                                            ->where('paket','=',$id)
                                            ->get();
    }

    public function ubahStatusTestimoni($id, $status){
        $jadwal = RatingPaketKonsultanModel::find($id);
        $jadwal->testimoni = $status;
        $jadwal->save();
    }

    public function getTestimoniPaket($idpaket){
    return RatingPaketKonsultanModel::select('review_paket.*','member.username')
                                    ->join('hbelipaket','hbelipaket.id','=','review_paket.idbeli')
                                    ->join('member','member.id','=','hbelipaket.iduser')
                                    ->where('hbelipaket.idpaket','=',$idpaket)
                                    ->where('review_paket.testimoni','=',1)
                                    ->get();
    }
}
