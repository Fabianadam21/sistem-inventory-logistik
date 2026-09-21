<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'current_password' => 'nullable|string',

            'password' => 'nullable|string|min:8|confirmed',
        ]);

        /*
         * Jika user ingin mengganti password,
         * password lama wajib benar.
         */
        if (!empty($validated['password'])) {

            if (
                empty($validated['current_password']) ||
                !Hash::check(
                    $validated['current_password'],
                    $user->password
                )
            ) {
                throw ValidationException::withMessages([
                    'current_password' =>
                        'Password saat ini tidak sesuai.',
                ]);
            }

            $user->password = Hash::make(
                $validated['password']
            );
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with(
                'success',
                'Profile berhasil diperbarui.'
            );
    }
}