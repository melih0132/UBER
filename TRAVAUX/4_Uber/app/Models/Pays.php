<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    use HasFactory;

    protected $table = 'pays';
    protected $primaryKey = 'idpays';
    public $timestamps = false;

    protected $fillable = [
        'idpays',
        'nompays',
        'pourcentagetva',
    ];

    public function codePostaux()
    {
        return $this->hasMany(Code_postal::class, 'idpays', 'idpays');
    }

    public function villes()
    {
        return $this->hasMany(Ville::class, 'idpays', 'idpays');
    }
}