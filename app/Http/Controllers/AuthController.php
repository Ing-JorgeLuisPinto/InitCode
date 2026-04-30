<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function selectLevel()
    {
        return view('auth.select-level', ['levels' => Level::all()]);
    }

    public function saveLevel(Request $request)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
        ]);

        Auth::user()->update(['level_id' => $request->level_id]);

        return redirect()->route('dashboard');
    }
}
