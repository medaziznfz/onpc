<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecificActivityErp extends Model
{
    // Si vous avez une table différente, vous pouvez spécifier le nom de la table
    protected $table = 'activitiesErp'; // Assurez-vous que le nom de la table correspond

    // Si nécessaire, définissez les colonnes que vous souhaitez mass-assign
    protected $fillable = ['name'];  // Assurez-vous que la colonne 'name' existe dans la table
}
