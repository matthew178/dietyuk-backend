<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisPaketModel extends Model
{
    protected $table= 'jenispaket';
    protected $primaryKey = 'idjenispaket';
    public $incrementing = false;
    protected $fillable= [
        'idjenispaket',
        'namajenispaket',
        'deskripsijenis'
    ];
    public $timestamps= false;
}
