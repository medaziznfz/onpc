<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'gouvernorat',
        'delegation',
        'type_activite',
        'activity',
        'statut',
        'verified_at',
        'expiry_at',
        'hash'
    ];
    
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function visites()
    {
        return $this->hasMany(Visite::class);
    }

    public function gouvernorat()
    {
        return $this->belongsTo(Governorate::class, 'id');
    }

    
    public function delegation()
    {
        return $this->belongsTo(Delegation::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

    public function getGouvernoratNameAttribute()
    {
        return Governorate::where('id', $this->gouvernorat)->value('name') ?? 'N/A';
    }

    public function getDelegationNameAttribute()
    {
        return Delegation::where('id', $this->delegation)->value('name') ?? 'N/A';
    }

    public function getTypeActiviteNameAttribute()
    {
        return TypeActivite::where('id', $this->type_activite)->value('nom') ?? 'N/A';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at;
    }

    public function getFormattedExpiryAtAttribute()
    {
        return $this->expiry_at;
    }
}
