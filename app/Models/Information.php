<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    const COMERCIAL= 1;
    const LABORAL = 2;
    const FAMILIAR = 3;
    const PENAL = 4;
    const CIVIL = 5;
    const INMOBILIARIO = 6;

    protected $fillable = [
        'name', 'body','cover_photo', 'category'
    ];
}
