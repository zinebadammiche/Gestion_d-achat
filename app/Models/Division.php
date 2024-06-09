<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'departement_id','chef_division_id'];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function chefd()
    {
            return $this->hasOne(User::class, 'id','chef_division_id')->whereHas('roles', function($query) {
            $query->where('name', 'Chef division');
        });
    }
 

}
