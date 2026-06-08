<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'leader_id',
        'title',
        'subj_code',
        'description',
        'venue',
        'session_date',
        'session_time'
    ];

    /**
     * The leader who created the group.
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * The members enrolled in the group.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id')
                    ->withTimestamps();
    }

    // ==========================================================
    // MEMBER 3 BACKEND EXCLUSIVE: MODEL QUERY SCOPES
    // ==========================================================

    /**
     * Query scope: Search by subject code
     */
    public function scopeSearchBySubject($query, $subjectCode)
    {
        if (!empty($subjectCode)) {
            return $query->where('subj_code', 'LIKE', '%' . $subjectCode . '%');
        }
        return $query;
    }

    /**
     * Query scope: Search by title or keyword
     */
    public function scopeSearchByTitle($query, $title)
    {
        if (!empty($title)) {
            return $query->where('title', 'LIKE', '%' . $title . '%');
        }
        return $query;
    }

    /**
     * Query scope: Search by exam/session date
     */
    public function scopeSearchByDate($query, $date)
    {
        if (!empty($date)) {
            return $query->whereDate('session_date', $date);
        }
        return $query;
    }

    /**
     * Query scope: Filter groups led by user
     */
    public function scopeLedBy($query, $userId)
    {
        return $query->where('leader_id', $userId);
    }

    /**
     * Query scope: Filter groups joined by user
     */
    public function scopeJoinedBy($query, $userId)
    {
        return $query->whereHas('members', function ($subQuery) use ($userId) {
            $subQuery->where('user_id', $userId);
        });
    }
}