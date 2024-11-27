<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function lawyers():BelongsToMany
    {
        return $this->belongsToMany(Lawyer::class, 'area_lawyers', 'area_id', 'lawyer_id');
    }

}
