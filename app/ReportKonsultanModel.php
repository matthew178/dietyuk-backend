<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportKonsultanModel extends Model
{
    protected $table= 'report_konsultan';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'tanggal_report',
        'id_member',
        'id_konsultan',
        'keterangan'
    ];
    public $timestamps= false;

    public function getReport($idtrans){
        return ReportKonsultanModel::select("report_konsultan.*")
                                    ->where('idtransaksi','=',$idtrans)
                                    ->get();
    }

    public function getAllReportKonsultan(){
        return ReportKonsultanModel::select("report_konsultan.*","m.username as pelapor","m2.username as konsultan")
                                    ->join('member as m', 'm.id','=','report_konsultan.id_member')
                                    ->join('member as m2', 'm2.id','=','report_konsultan.id_konsultan')
                                    ->where('report_konsultan.status','=',0)
                                    ->get();
    }
}
