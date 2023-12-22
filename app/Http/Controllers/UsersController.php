<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return Inertia::render('Users/ListUsers', compact('users'));
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
        return Inertia::render('Users/EditUser', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->only('name', 'document'));

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

    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $users = User::select('id')
            ->selectRaw('concat(name, " - ", document) as text')
            ->where('name', 'LIKE', "%$searchTerm%")
            ->orWhere('document', 'LIKE', "%$searchTerm%")
            ->take(10)
            ->get();

        return response()->json($users);
    }
}
