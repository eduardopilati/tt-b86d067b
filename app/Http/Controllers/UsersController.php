<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(6);
        return Inertia::render('Users/ListUsers', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/CreateUser');
    }

    public function store(CreateUserRequest $request)
    {
        User::create($request->all());
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/EditUser', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->only('name', 'document', 'admin'));

        if ($request->filled('password')) {
            $user->update([
                'password' => $request->password,
            ]);
        }

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
