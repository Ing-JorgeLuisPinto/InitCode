<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class FixBestStreak extends Command
{
    protected $signature   = 'fix:best-streak';
    protected $description = 'Recalculate best_streak for all users based on their current streak_days';

    public function handle()
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // best_streak should be at least as high as current streak_days
            // If best_streak is less than streak_days, correct it
            if (($user->best_streak ?? 0) < ($user->streak_days ?? 0)) {
                DB::table('users')->where('id', $user->id)->update([
                    'best_streak' => $user->streak_days
                ]);
                $this->info("Fixed user {$user->name}: best_streak set to {$user->streak_days}");
            } else {
                $this->info("User {$user->name}: best_streak = {$user->best_streak} (OK)");
            }
        }

        $this->info('Done!');
    }
}
