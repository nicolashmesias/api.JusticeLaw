<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_document_id', 'document_number', 'email', 'password'
    ];

    public function typeDocument(){
        return $this->belongsTo(TypeDocument::class);
    }

    public function overhaulReviews()
    {
        return $this->hasMany(OverhaulReview::class, 'administrators_id');
    }
    
}
