<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', User::class);

        $users = User::query()
            ->orderBy('role')
            ->paginate(10)
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => UserRoleEnum::labels()[$user->role->value] ?? $user->role,
                'created_at' => $user->created_at,
            ]);

        return Inertia::render('admin/users/Index', [
            'users' => $users,
            'roles' => UserRoleEnum::options(),
        ]);
    }

    public function create()
    {
        Gate::authorize('create', User::class);

        return Inertia::render('admin/users/Form', [
            'roles' => UserRoleEnum::options(),
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|string|in:' . implode(',', array_map(fn($role) => $role->value, UserRoleEnum::cases())),
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('message', 'Utilisateur créé avec succès');
    }

    public function show(User $user)
    {

        Gate::authorize('view', $user);

        return Inertia::render('admin/users/Show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => UserRoleEnum::labels()[$user->role->value] ?? $user->role,
                'created_at' => $user->created_at,
            ],
        ]);
    }

    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        return Inertia::render('admin/users/Form', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'roles' => UserRoleEnum::options(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:' . implode(',', array_map(fn($role) => $role->value, UserRoleEnum::cases())),
            'password' => $request->filled('password') ? ['confirmed', Password::defaults()] : '',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('message', 'Utilisateur mis à jour avec succès');
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return redirect()->route('admin.users.index')->with('message', 'Utilisateur supprimé avec succès');
    }
}
