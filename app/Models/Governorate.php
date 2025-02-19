<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Certificat;

class Governorate extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'name', 'created_at', 'updated_at']; // Guarding unnecessary fields


    public function delegations()
        {
            return $this->hasMany(\App\Models\Delegation::class, 'id_gouver');
        }

    public function requests()
    {
        return $this->hasMany(Certificat::class);
    }

}
