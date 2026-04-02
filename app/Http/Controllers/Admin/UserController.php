<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'branch'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $branches = Branch::all();
        return view('admin.users.create', compact('roles', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'nullable|exists:branches,id',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'branch_id' => $validated['branch_id'],
            'is_active' => true,
        ]);

        $role = Role::findOrFail($validated['role_id']);
        $user->roles()->attach($role);

        return redirect()->route('admin.users.index')->with('success', 'User ' . strtoupper($role->name) . ' berhasil dibuat.');
    }

    public function show($id)
    {
        $user = User::with(['roles', 'branch', 'auditLogs'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $branches = Branch::all();
        return view('admin.users.edit', compact('user', 'roles', 'branches'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.users.index');
    }

    public function assignRole(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }

    public function changeBranch(Request $request, $id)
    {
        return response()->json(['success' => true]);
    }

    public function deactivate($id)
    {
        return response()->json(['success' => true]);
    }
}
