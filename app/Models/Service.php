<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'division_id','chef_service_id'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function chefs()
    {
           return $this->hasOne(User::class, 'id','chef_service_id')->whereHas('roles', function($query) {
               
            $query->where('name', 'Chef service');
        });
    }
}

