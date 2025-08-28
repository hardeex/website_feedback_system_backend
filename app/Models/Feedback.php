<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table="feedbacks";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'comment',
        'rating',
        'developer_response',
        'status',
    ];

    /**
     * Get the project that owns the feedback.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}