<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Keeps Member 1's profile configurations intact.
     */
    protected $fillable = [
        'name',
        'matric_number', // Modified by Member 1
        'email',
        'password',
        'expertise_area', // Modified by Member 1
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // MEMBER 3 ADDITIONS: RELATIONSHIPS
    // ==========================================

    /**
     * Groups created and led by this user (One-to-Many).
     */
    public function ledGroups()
    {
        return $this->hasMany(StudyGroup::class, 'leader_id');
    }

    /**
     * Groups joined by this user (Many-to-Many via pivot table).
     */
    public function joinedGroups()
    {
        return $this->belongsToMany(StudyGroup::class, 'group_members', 'user_id', 'group_id')
                    ->withTimestamps();
    }
}