<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'icon', 'order', 'is_premium', 'level_id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function getProgressForUser(User $user): float
    {
        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) return 0;

        $completedLessons = UserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $this->lessons()->pluck('id'))
            ->count();

        return round(($completedLessons / $totalLessons) * 100, 2);
    }
}
