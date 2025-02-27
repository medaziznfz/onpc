<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cin',      
        'role',      
        'gouver',    
        'grade_id',  // Added grade_id
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'cin' => 'string',
            'role' => 'integer',
            'gouver' => 'integer',
            'grade_id' => 'integer',
        ];
    }

    /**
     * Relationship: A User belongs to a Grade.
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function governorate()
    {
        return $this->belongsTo(\App\Models\Governorate::class, 'gouver');
    }


    /**
     * Relationship: A User has many Notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }


    /**
     * Get unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->where('read', false);
    }
}
