<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dbeliproduk extends Model
{
    protected $table= 'dbeliproduk';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'idbeli',
        'idproduk',
		'jumlah',
		'harga',
		'subtotal'
    ];
    public $timestamps= false;
}
