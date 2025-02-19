<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificat;
use App\Models\Delegation;

class Delegation extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'id_gouver', 'name', 'created_at', 'updated_at']; // Guarding unnecessary fields

    public function governorate()
    {
        return $this->belongsTo(\App\Models\Governorate::class);
    }

    public function requests()
    {
        return $this->hasMany(Certificat::class,'gouvernorat');
    }
    
    
    
}
