<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProvinsiModel extends Model
{
    protected $table= 'provinsi';
    protected $primaryKey = 'id_provinsi';
    public $incrementing = true;
    protected $fillable= [
        'id_provinsi',
        'nama_provinsi'
    ];
    public $timestamps= false;
}
