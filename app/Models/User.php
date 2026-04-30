<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'level_id',
        'xp',
        'streak_days',
        'last_activity_date',
        'is_premium',
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
            'last_activity_date' => 'date',
            'is_premium' => 'boolean',
        ];
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function userExerciseAttempts(): HasMany
    {
        return $this->hasMany(UserExerciseAttempt::class);
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function userAchievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function achievements(): HasManyThrough
    {
        return $this->hasManyThrough(Achievement::class, UserAchievement::class, 'user_id', 'id', 'id', 'achievement_id');
    }

    public function addXP(int $amount): void
    {
        $this->increment('xp', $amount);
        $this->checkLevelUp();
    }

    public function checkLevelUp(): bool
    {
        $newLevel = Level::where('min_xp', '<=', $this->xp)
            ->where('max_xp', '>=', $this->xp)
            ->first();

        if ($newLevel && $newLevel->id !== $this->level_id) {
            $this->update(['level_id' => $newLevel->id]);
            return true;
        }

        return false;
    }

    public function updateStreak(): void
    {
        $today = now()->startOfDay();
        $lastActivity = $this->last_activity_date ? $this->last_activity_date->startOfDay() : null;

        if (!$lastActivity) {
            $this->streak_days = 1;
        } else {
            $diff = $today->diffInDays($lastActivity);

            if ($diff === 1) {
                $this->increment('streak_days');
            } elseif ($diff > 1) {
                $this->streak_days = 1;
            }
            // If diff == 0, no change
        }

        $this->last_activity_date = $today;
        $this->save();
    }

    public function checkAchievements(): array
    {
        $achievements = Achievement::all();
        $earnedIds = $this->userAchievements()->pluck('achievement_id')->toArray();
        $newAchievements = [];

        foreach ($achievements as $achievement) {
            if (in_array($achievement->id, $earnedIds)) {
                continue;
            }

            $conditionMet = false;
            switch ($achievement->condition_type) {
                case 'exercises_completed':
                    $conditionMet = $this->userExerciseAttempts()->where('is_correct', true)->count() >= $achievement->condition_value;
                    break;
                case 'streak_days':
                    $conditionMet = $this->streak_days >= $achievement->condition_value;
                    break;
                case 'courses_started':
                    $conditionMet = UserProgress::where('user_id', $this->id)
                        ->join('lessons', 'user_progress.lesson_id', '=', 'lessons.id')
                        ->distinct('lessons.course_id')
                        ->count() >= $achievement->condition_value;
                    break;
                case 'first_try_correct':
                    $conditionMet = $this->userExerciseAttempts()->where('is_correct', true)->count() >= $achievement->condition_value;
                    break;
            }

            if ($conditionMet) {
                UserAchievement::create([
                    'user_id' => $this->id,
                    'achievement_id' => $achievement->id,
                    'earned_at' => now(),
                ]);
                $newAchievements[] = $achievement;
            }
        }
        return $newAchievements;
    }
}
