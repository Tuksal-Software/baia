<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role')) {
            if ($request->get('role') === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->get('role') === 'user') {
                $query->where('is_admin', false);
            }
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = $request->boolean('is_admin');

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Kullanici basariyla olusturuldu.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_admin' => ['boolean'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $validated['is_admin'] = $request->boolean('is_admin');

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Kullanici basariyla guncellendi.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kendi hesabinizi silemezsiniz.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Kullanici basariyla silindi.');
    }

    /**
     * Toggle admin status.
     */
    public function toggleAdmin(User $user): RedirectResponse
    {
        // Prevent self-demotion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kendi admin durumunuzu degistiremezsiniz.');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $message = $user->is_admin
            ? 'Kullaniciya admin yetkisi verildi.'
            : 'Kullanicinin admin yetkisi kaldirildi.';

        return back()->with('success', $message);
    }
}
