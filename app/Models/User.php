<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasRoles,Notifiable;

    // Attributs pouvant être remplis
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Attributs à masquer lors de la conversion en tableau ou en JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Attributs à convertir automatiquement en types natifs
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'directeur_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'chef_division_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'chef_service_id');
    }
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
