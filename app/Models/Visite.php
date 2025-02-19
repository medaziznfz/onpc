<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    protected $fillable = [
        'certificat_id',
        'date_visite',
        'heure_visite',
        'status',
        'remarque',
    ];

    // Relation: une visite appartient à un certificat
    public function certificat()
    {
        return $this->belongsTo(Certificat::class);
    }
}
