<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'director_id'];

    public function director()
    {
        
            return $this->hasOne(User::class, 'id','directeur_id')->whereHas('roles', function($query) {
                $query->where('name', 'Directeur');
            });
            
        
    }
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}

