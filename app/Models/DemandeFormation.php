<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeFormation extends Model
{
    use HasFactory;

    protected $table = 'demande_formation';

    protected $fillable = [
        'id',
        'id_user',
        'gouvernerat',
        'delegation',
        'formation_id',
        'status'
    ];
    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'gouvernerat');
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
    public function gouvernorat()
    {
        return $this->belongsTo(Governorate::class, 'gouvernerat');
    }
    public function delegation()
    {
        return $this->belongsTo(Delegation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function formationAcceptee()
    {
        return $this->hasOne(FormationAccepter::class, 'demande_id');
    }
        
}
