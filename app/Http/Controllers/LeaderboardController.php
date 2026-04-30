<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::with('level')
            ->orderBy('xp', 'desc')
            ->take(10)
            ->get();

        return view('leaderboard.index', compact('users'));
    }
}
