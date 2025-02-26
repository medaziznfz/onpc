<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormationAccepter extends Model
{
    use HasFactory;

    // Précisez le nom de la table si celui-ci ne suit pas la convention (ici formation_accepter)
    protected $table = 'formation_accepter';

    // Champs que l'on peut assigner en masse
    protected $fillable = [
        'formation_id',
        'demande_id',
        'date_prevue',
    ];
}
