<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable implements MustVerifyEmail
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
        'avatar',
        'bio',
        'level_id',
        'xp',
        'streak_days',
        'best_streak',
        'last_activity_date',
        'is_premium',
        'is_admin',
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
            'xp' => 'integer',
            'streak_days' => 'integer',
            'best_streak' => 'integer',
            'is_premium' => 'boolean',
            'is_admin' => 'boolean',
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
        // Always read fresh values from DB to avoid stale cache
        $freshUser = \DB::table('users')->where('id', $this->id)
            ->select('streak_days', 'best_streak', 'last_activity_date')
            ->first();

        $currentBest   = $freshUser->best_streak ?? 0;
        $currentStreak = $freshUser->streak_days ?? 0;

        $today     = \Carbon\Carbon::now()->format('Y-m-d');
        $yesterday = \Carbon\Carbon::now()->subDay()->format('Y-m-d');

        $lastActivity = $freshUser->last_activity_date
            ? \Carbon\Carbon::parse($freshUser->last_activity_date)->format('Y-m-d')
            : null;

        \Log::info('Streak update - today: ' . $today .
            ', lastActivity: ' . ($lastActivity ?? 'null') .
            ', currentStreak: ' . $currentStreak .
            ', currentBest: ' . $currentBest);

        // Already updated today
        if ($lastActivity === $today) {
            \Log::info('Already updated today, skipping');
            return;
        }

        if ($lastActivity === $yesterday) {
            $newStreak = $currentStreak + 1;
            \Log::info('Consecutive day! New streak: ' . $newStreak);
        } else {
            $newStreak = 1;
            \Log::info('Gap or first time. Reset to 1');
        }

        // Update best_streak if new streak beats the record
        $newBest = max($newStreak, $currentBest);

        \Log::info('New best streak: ' . $newBest);

        \DB::table('users')->where('id', $this->id)->update([
            'streak_days'        => $newStreak,
            'last_activity_date' => $today,
            'best_streak'        => $newBest,
        ]);

        // Sync local instance
        $this->streak_days        = $newStreak;
        $this->last_activity_date = $today;
        $this->best_streak        = $newBest;
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

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\CustomResetPassword($token));
    }
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new \App\Notifications\VerifyEmailNotification());
    }
}
