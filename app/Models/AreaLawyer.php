<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaLawyer extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_id',
        'lawyer_id'
    ];

}
