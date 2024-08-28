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

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function lawyer(){
        return $this->belongsTo(Lawyer::class);
    }
    
}
