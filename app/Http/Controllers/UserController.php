<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:owner,pelanggan',
        ]);

        return User::create($validated);
    }

    public function show($id_user)
    {
        return User::findOrFail($id_user);
    }

    public function update(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);

        $validated = $request->validate([
            'username' => 'string|max:255|unique:users,username,' . $id_user . ',id_user',
            'email' => 'email|max:255|unique:users,email,' . $id_user . ',id_user',
            'password' => 'nullable|string|min:8',
            'role' => 'in:owner,pelanggan',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return $user;
    }

    public function destroy($id_user)
    {
        $user = User::findOrFail($id_user);
        $user->delete();

        return response()->noContent();
    }
}
