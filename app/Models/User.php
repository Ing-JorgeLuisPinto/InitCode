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
        'avatar',
        'bio',
        'level_id',
        'xp',
        'streak_days',
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
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        $yesterday = \Carbon\Carbon::now()->subDay()->format('Y-m-d');

        // Get last activity as plain Y-m-d string regardless of format
        $lastActivity = null;
        if ($this->last_activity_date) {
            $lastActivity = \Carbon\Carbon::parse($this->last_activity_date)
                ->format('Y-m-d');
        }

        \Log::info('Streak check - today: ' . $today . 
            ', yesterday: ' . $yesterday . 
            ', lastActivity: ' . ($lastActivity ?? 'null') .
            ', current streak: ' . ($this->streak_days ?? 0));

        // Already updated today
        if ($lastActivity === $today) {
            \Log::info('Already updated today, skipping');
            return;
        }

        if ($lastActivity === $yesterday) {
            // Consecutive day — increment
            $newStreak = ($this->streak_days ?? 0) + 1;
            \Log::info('Consecutive day! New streak: ' . $newStreak);
        } else {
            // Gap or first time — reset to 1
            $newStreak = 1;
            \Log::info('Gap detected or first time. Reset to 1');
        }

        // Use DB update to avoid any casting issues
        \DB::table('users')->where('id', $this->id)->update([
            'streak_days' => $newStreak,
            'last_activity_date' => $today,
        ]);

        // Refresh local instance
        $this->streak_days = $newStreak;
        $this->last_activity_date = $today;
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
