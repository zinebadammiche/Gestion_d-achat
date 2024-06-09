<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function sousModules()
    {
        return $this->hasMany(SousModule::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
