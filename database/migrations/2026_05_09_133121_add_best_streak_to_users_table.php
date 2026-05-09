<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('best_streak')->default(0)->after('streak_days');
        });

        // Backfill existing users: sets best_streak = current streak_days as a starting point.
        \DB::table('users')->update([
            'best_streak' => \DB::raw('streak_days')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('best_streak');
        });
    }
};
