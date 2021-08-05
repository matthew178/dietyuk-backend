<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hbeliproduk extends Model
{
    protected $table= 'hbeliproduk';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'pemesan',
		'konsultan',
		'alamat',
		'waktubeli',
        'total',
        'status',
        'nomorresi'
    ];
    public $timestamps= false;
}
