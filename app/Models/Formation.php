<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $table = 'formation';

    protected $fillable = [
        'name',
    ];
    public function demandes()
    {
        return $this->hasMany(DemandeFormation::class);
    }
}
