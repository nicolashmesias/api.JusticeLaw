<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function administrators(){
        return $this->hasMany(Administrator::class);
    }

    public function lawyers(){
        return $this->hasMany(Lawyer::class);
    }
}
