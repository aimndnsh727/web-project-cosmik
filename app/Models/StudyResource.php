<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_group_id',
        'user_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size'
    ];

    /**
     * Get the study group that owns the resource.
     */
    public function studyGroup()
    {
        return $this->belongsTo(StudyGroup::class);
    }

    /**
     * Get the user who uploaded the resource.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
