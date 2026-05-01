<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class FixStreaks extends Command
{
    protected $signature = 'fix:streaks';
    protected $description = 'Fix broken streak data';

    public function handle()
    {
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            if (!$user->last_activity_date) continue;

            $lastActivity = Carbon::parse($user->last_activity_date)->format('Y-m-d');
            $today = Carbon::now()->format('Y-m-d');
            $yesterday = Carbon::now()->subDay()->format('Y-m-d');

            $daysDiff = Carbon::parse($lastActivity)->diffInDays(Carbon::now());

            if ($daysDiff > 1) {
                // Streak is broken — reset to 0
                DB::table('users')->where('id', $user->id)
                    ->update(['streak_days' => 0]);
                $this->info("Reset streak for: " . $user->name . 
                    " (last activity: " . $lastActivity . ")");
            } else {
                $this->info("Streak OK for: " . $user->name . 
                    " (streak: " . $user->streak_days . " days)");
            }
        }
        $this->info('Done!');
    }
}
