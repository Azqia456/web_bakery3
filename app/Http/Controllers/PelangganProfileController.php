<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PelangganProfileController extends Controller
{
    /**
     * Display the pelanggan profile form
     */
    public function edit(): View
    {
        $user = Auth::user();
        $pelanggan = Pelanggan::where('id_user', $user->id_user)->first();

        // Jika pelanggan belum ada, buat record baru
        if (!$pelanggan) {
            $pelanggan = Pelanggan::firstOrCreate(
                ['email' => $user->email],
                [
                    'id_user' => $user->id_user,
                    'nama' => $user->username ?? 'Pelanggan',
                    'no_tlp' => $user->no_telpon ?? '',
                    'alamat' => $user->alamat ?? '',
                    'bio' => '',
                    'status' => 'Online',
                ]
            );
        }

        return view('pelanggan.profile', [
            'pelanggan' => $pelanggan,
            'user' => $user,
        ]);
    }

    /**
     * Update pelanggan profile information
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $pelanggan = Pelanggan::where('id_user', $user->id_user)->first();

        // Jika pelanggan belum ada, buat record baru
        if (!$pelanggan) {
            $pelanggan = Pelanggan::firstOrCreate(
                ['email' => $user->email],
                [
                    'id_user' => $user->id_user,
                    'nama' => $user->username ?? 'Pelanggan',
                    'no_tlp' => $user->no_telpon ?? '',
                    'alamat' => $user->alamat ?? '',
                    'bio' => '',
                    'status' => 'Online',
                ]
            );
        }

        // Validate input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $user->id_user . ',id_user',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_tlp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto_profil')) {
            // Delete old foto if exists
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $file = $request->file('foto_profil');
            $filename = 'profile_' . $user->id_user . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile-photos', $filename, 'public');
            $validated['foto_profil'] = $path;
        }

        // Update user data
        $userUpdate = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'no_telpon' => $validated['no_tlp'],
            'alamat' => $validated['alamat'],
        ];

        if (isset($validated['foto_profil'])) {
            $userUpdate['foto_profil'] = $validated['foto_profil'];
        }

        $user->update($userUpdate);

        // Update pelanggan data
        $pelangganUpdate = [
            'nama' => $validated['nama'],
            'no_tlp' => $validated['no_tlp'],
            'email' => $validated['email'],
            'alamat' => $validated['alamat'],
            'bio' => $validated['bio'] ?? null,
        ];

        $pelanggan->update($pelangganUpdate);

        return redirect()->route('pelanggan.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
