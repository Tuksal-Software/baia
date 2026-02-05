<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Ad soyad gereklidir.',
            'email.required' => 'E-posta gereklidir.',
            'email.email' => 'Gecerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kayitli.',
            'password.required' => 'Sifre gereklidir.',
            'password.min' => 'Sifre en az 8 karakter olmalidir.',
            'password.confirmed' => 'Sifreler eslesmiyor.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Hesabiniz basariyla olusturuldu.');
    }
}
