<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\UserProgress;
use DB;

class FixDuplicates extends Command
{
    protected $signature = 'fix:duplicates';
    protected $description = 'Remove duplicate lessons keeping only the latest';

    public function handle()
    {
        // Find duplicate lessons (same course_id + slug)
        $duplicates = DB::table('lessons')
            ->select('course_id', 'slug', DB::raw('COUNT(*) as count'), 
                     DB::raw('MIN(id) as keep_id'))
            ->groupBy('course_id', 'slug')
            ->having('count', '>', 1)
            ->get();

        $this->info('Found ' . $duplicates->count() . ' duplicate groups');

        foreach ($duplicates as $dup) {
            // Get all IDs for this slug except the one to keep
            $idsToDelete = DB::table('lessons')
                ->where('course_id', $dup->course_id)
                ->where('slug', $dup->slug)
                ->where('id', '!=', $dup->keep_id)
                ->pluck('id');

            if ($idsToDelete->isEmpty()) continue;

            // Delete related exercises first
            DB::table('exercises')
                ->whereIn('lesson_id', $idsToDelete)
                ->delete();

            // Delete related user_progress
            DB::table('user_progress')
                ->whereIn('lesson_id', $idsToDelete)
                ->delete();

            // Delete related user_exercise_attempts
            $exerciseIds = DB::table('exercises')
                ->whereIn('lesson_id', $idsToDelete)
                ->pluck('id');
            if ($exerciseIds->isNotEmpty()) {
                DB::table('user_exercise_attempts')
                    ->whereIn('exercise_id', $exerciseIds)
                    ->delete();
            }

            // Delete duplicate lessons
            DB::table('lessons')
                ->whereIn('id', $idsToDelete)
                ->delete();

            $this->info('Cleaned slug: ' . $dup->slug . 
                ' (deleted ' . $idsToDelete->count() . ' duplicates)');
        }

        // Also fix duplicate user_progress (same user_id + lesson_id)
        $dupProgress = DB::table('user_progress')
            ->select('user_id', 'lesson_id', 
                     DB::raw('COUNT(*) as count'),
                     DB::raw('MIN(id) as keep_id'))
            ->groupBy('user_id', 'lesson_id')
            ->having('count', '>', 1)
            ->get();

        foreach ($dupProgress as $dp) {
            DB::table('user_progress')
                ->where('user_id', $dp->user_id)
                ->where('lesson_id', $dp->lesson_id)
                ->where('id', '!=', $dp->keep_id)
                ->delete();
        }

        $this->info('Fixed ' . $dupProgress->count() . ' duplicate progress records');
        $this->info('Done! Run php artisan fix:streaks next.');
    }
}
