<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerificationCode;
use App\Notifications\VerifyEmailOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailOtpController extends Controller
{
    // Show the "enter your code" page
    public function show()
    {
        if (Auth::user()->email_verified_at) {
            return redirect()->route('dashboard');
        }
        return view('auth.verify-otp');
    }

    // Send a new OTP code
    public function send()
    {
        $user = Auth::user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        // Delete previous codes for this user
        EmailVerificationCode::where('user_id', $user->id)->delete();

        // Generate 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailVerificationCode::create([
            'user_id'    => $user->id,
            'code'       => $code,
            'expires_at' => now()->addMinutes(15),
        ]);

        $user->notify(new VerifyEmailOtp($code));

        return back()->with('status', 'code-sent');
    }

    // Verify the code the user entered
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Ingresa el código de verificación.',
            'code.size'     => 'El código debe tener exactamente 6 dígitos.',
        ]);

        $user = Auth::user();

        $record = EmailVerificationCode::where('user_id', $user->id)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return back()->withErrors([
                'code' => 'El código es incorrecto o ya expiró. Solicita uno nuevo.',
            ]);
        }

        // Mark as verified
        $user->email_verified_at = now();
        $user->save();

        // Delete used code
        $record->delete();

        if (!$user->level_id) {
            return redirect()->route('select-level');
        }

        return redirect()->route('dashboard');
    }
}
