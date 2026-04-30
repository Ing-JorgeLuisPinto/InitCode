<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = ['lesson_id', 'instructions', 'starter_code', 'solution_code', 'expected_output', 'hints', 'xp_reward'];

    protected $casts = [
        'hints' => 'array',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function userExerciseAttempts(): HasMany
    {
        return $this->hasMany(UserExerciseAttempt::class);
    }
}
