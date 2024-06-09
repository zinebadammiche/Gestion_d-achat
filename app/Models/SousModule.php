<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SousModule extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'name'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}

