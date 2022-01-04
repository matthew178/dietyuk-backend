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
        'review_konsultan'
    ];
    public $timestamps= false;
}
