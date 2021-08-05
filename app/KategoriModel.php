<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    protected $table= 'kategoriproduk';
    protected $primaryKey = 'kodekategori';
    public $incrementing = false;
    protected $fillable= [
        'kodekategori',
        'namakategori',
        'gambar',
        'icon'
    ];
    public $timestamps= false;
}
