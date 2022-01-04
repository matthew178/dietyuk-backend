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
}
