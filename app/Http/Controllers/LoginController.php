<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function login()
    {
        if(Auth::check()){
            return redirect('dktr');
        }
    }

    public function actionLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $emailKey = 'login-attempts:' . $email;
        $globalKey = 'global-login-attempts';

        if (RateLimiter::tooManyAttempts($globalKey, 5) || RateLimiter::tooManyAttempts($emailKey, 5)) {
            $seconds = max(
                RateLimiter::availableIn($globalKey),
                RateLimiter::availableIn($emailKey)
            );
            Session::flash('error', "Anda telah mencoba login terlalu sering. Silakan coba lagi dalam $seconds detik.");
            return redirect()->back();
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            RateLimiter::hit($emailKey, 60);
            RateLimiter::hit($globalKey, 60);
            Session::flash('error', 'Email Salah');
            return redirect()->back();
        }

        if (!Hash::check($password, $user->password)) {
            RateLimiter::hit($emailKey, 60);
            RateLimiter::hit($globalKey, 60);
            Session::flash('error', 'Password Salah');
            return redirect()->back();
        }

        Auth::login($user);
        RateLimiter::clear($emailKey);
        RateLimiter::clear($globalKey);

        session(['profile_picture' => $user->profile_picture]);

        return redirect('/');
    }


    public function actionLogout()
    {
        Auth::Logout();
        return redirect ('/');
    }

    public function registrasi()
    {
        return view ('login.registrasi');
    }

    public function create(Request $request)
    {
        Session::flash('name', $request->name);
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            Session::flash('error', 'Email sama, gunakan yang lain.');
            return redirect()->back()->withInput();
        }
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'required',
            'nohp' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Email Wajib Diisi',
            'email.email' => 'Silakan masukan email yang valid',
            'email.unique' => 'Email sudah pernah digunakan, silakan pilih email yang lain',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Password harus minimal 6 karakter.',
            'alamat.required' => 'Alamat Wajib Diisi',
            'nohp.required' => 'Nomor HP Wajib Diisi',
            'profile_picture.image' => 'File harus berupa gambar.',
            'profile_picture.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif.',
            'profile_picture.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public'); 
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'nohp' => $request->nohp,
            'role' => 'user',
            'profile_picture' => $profilePicturePath,
        ];
        User::create($data);

        return redirect('dktr')->with('success', 'Registrasi berhasil.');
    }
}
