<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('login.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
    
        $email = $request->email;
        $token = strtoupper(substr(str_shuffle('0123456789'), 0, 6)); // Hanya angka & capslock
    
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );
    
        // Gunakan queue untuk mengirim email dengan template
        Mail::to($email)->queue(new ResetPasswordMail($token));
    
        return response()->json(['status' => 'Kode reset telah dikirim ke email Anda.']);
    }
    

public function verifyResetCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'token' => 'required|string|min:6|max:6'
    ]);

    $tokenData = DB::table('password_reset_tokens')
        ->where('email', $request->email)
        ->first();

    if (!$tokenData) {
        return back()->withInput()->with('error', 'Kode reset tidak valid atau telah kedaluwarsa.');
    }

    if ($tokenData->token !== $request->token) {
        return back()->withInput()->with('error', 'Kode reset salah, silakan coba lagi.');
    }

    return redirect()->route('reset-password', [
        'email' => $request->email,
        'token' => $request->token
    ]);
}

    public function showResetPasswordForm(Request $request)
    {
        return view('login.reset-password', ['email' => $request->query('email'), 'token' => $request->query('token')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string|min:6|max:6',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Password dan konfirmasi password tidak cocok.',
        ]);

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return back()->with('error', 'Kode reset tidak valid atau telah kedaluwarsa.');
        }

        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diperbarui.');
    }

}
