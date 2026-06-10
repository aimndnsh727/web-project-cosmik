<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'study_group_id',
        'status',
        'message',
    ];

    // Relationship: A request belongs to a specific user (applicant)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A request belongs to a specific study group
    public function studyGroup()
    {
        return $this->belongsTo(StudyGroup::class);
    }
}
