<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheTechnique extends Model
{
    use HasFactory;

    protected $fillable = ['demande_id', 'article', 'caracteristique_technique', 'quantite'];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}

