<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

  
    protected $fillable = [
        'user_id',
        'module_id',
        'sous_module_id',
        'departement_id',
        'service_id',
        'detail',
        'justification',
        'status',
        'validation',
        'pdf_path',
        'date_de_livraison_souhaite',
        'credit_estimatif',
        'date_de_creation_demande',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function sousModule()
    {
        return $this->belongsTo(SousModule::class);
    }
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function ficheTechnique()
    {
        return $this->hasMany(FicheTechnique::class);
    }
}

