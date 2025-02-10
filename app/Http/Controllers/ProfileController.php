<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'profile_picture.image' => 'File harus berupa gambar.',
            'profile_picture.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'profile_picture.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Simpan file dan perbarui di database
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->update(['profile_picture' => $path]);
        }

        return redirect()->route('profile.index')->with('success', 'Foto profil berhasil diperbarui!');
    }
}
