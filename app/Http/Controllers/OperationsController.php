<?php

namespace App\Http\Controllers;

use App\Models\OperationUser;
use Illuminate\Http\Request;

class OperationsController extends Controller
{
    public function index()
    {
        $users = OperationUser::orderByDesc('id')->paginate(10);
        return view('operations.index', compact('users'));
    }

    public function create()
    {
        return view('operations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160', 'unique:operation_users,email'],
        ]);
        OperationUser::create($data);
        return redirect()->route('operations.index')->with('status', 'User created.');
    }

    public function edit(OperationUser $user)
    {
        return view('operations.edit', ['user' => $user]);
    }

    public function update(Request $request, OperationUser $user)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160', 'unique:operation_users,email,' . $user->id],
        ]);
        $user->update($data);
        return redirect()->route('operations.index')->with('status', 'User updated.');
    }

    public function destroy(OperationUser $user)
    {
        $user->delete();
        return redirect()->route('operations.index')->with('status', 'User deleted.');
    }
}
