<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function send(
        User $user,
        string $type,
        string $title,
        string $message,
        string $icon = '🔔',
        string $link = null
    ): void {
        // Avoid duplicate notifications of same type within last 24 hours
        $recent = Notification::where('user_id', $user->id)
            ->where('type', $type)
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();

        if (!$recent) {
            Notification::create([
                'user_id' => $user->id,
                'type'    => $type,
                'title'   => $title,
                'message' => $message,
                'icon'    => $icon,
                'link'    => $link,
                'read'    => false,
            ]);
        }
    }

    public static function achievement(User $user, $achievement): void
    {
        self::send(
            $user,
            'achievement_' . $achievement->id,
            '¡Logro desbloqueado!',
            'Obtuviste el logro: ' . $achievement->name,
            $achievement->icon,
            '/profile'
        );
    }

    public static function levelUp(User $user, $level): void
    {
        self::send(
            $user,
            'level_up_' . $level->id,
            '¡Subiste de nivel!',
            'Ahora eres ' . $level->icon . ' ' . $level->name . '. ¡Sigue así!',
            '⬆️',
            '/profile'
        );
    }

    public static function streakRisk(User $user): void
    {
        self::send(
            $user,
            'streak_risk',
            '¡Tu racha está en riesgo!',
            'Llevas ' . $user->streak_days . ' días. Practica hoy para mantenerla.',
            '⚠️',
            '/courses'
        );
    }

    public static function streakLost(User $user): void
    {
        self::send(
            $user,
            'streak_lost',
            'Perdiste tu racha',
            'Tu racha de días se reinició. ¡Empieza una nueva hoy!',
            '💔',
            '/courses'
        );
    }

    public static function courseComplete(User $user, $course): void
    {
        self::send(
            $user,
            'course_complete_' . $course->id,
            '¡Curso completado!',
            'Completaste ' . $course->icon . ' ' . $course->title . '. ¡Descarga tu certificado!',
            '🏆',
            '/courses/' . $course->slug
        );
    }

    public static function leaderboardPassed(User $user, User $passer): void
    {
        self::send(
            $user,
            'leaderboard_passed',
            '¡Te superaron en el ranking!',
            $passer->name . ' te adelantó en la clasificación. ¡Practica para recuperar tu puesto!',
            '🏅',
            '/leaderboard'
        );
    }
}
