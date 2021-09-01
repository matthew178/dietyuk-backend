<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackingBeratModel extends Model
{
    protected $table= 'trackingberat';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable= [
        'id',
        'username',
        'tanggal',
        'berat'
    ];
    public $timestamps= false;
}
