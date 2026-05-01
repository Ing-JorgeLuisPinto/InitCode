<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UpdateStreakMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user()->fresh(); // always get fresh from DB
            
            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $lastActivity = $user->last_activity_date
                ? \Carbon\Carbon::parse($user->last_activity_date)->format('Y-m-d')
                : null;

            if ($lastActivity !== $today) {
                $user->updateStreak();
            }
        }

        return $next($request);
    }
}
