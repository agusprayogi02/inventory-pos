<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function data()
  {
    $users = User::with('roles')->get();
    return DataTables::of($users)
      ->addColumn('roles', function (User $user) {
        return $user->roles->pluck('name')->implode(', ');
      })
      ->addColumn('action', function (User $user) {
        return view('user.action', compact('user'))->render();
      })
      ->rawColumns(['action', 'roles'])
      ->make(true);
  }

  public function index()
  {
    return view('user.index');
  }

  public function create()
  {
    $roles = Role::all();
    return view('user.create', compact('roles'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8|confirmed',
      'roles' => 'array',
    ]);
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);
    if ($request->roles) {
      $user->syncRoles($request->roles);
    }
    return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
  }

  public function edit($id)
  {
    $user = User::findOrFail($id);
    $roles = Role::all();
    return view('user.edit', compact('user', 'roles'));
  }

  public function update(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
      'password' => 'nullable|string|min:8|confirmed',
      'roles' => 'array',
    ]);
    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->password) {
      $user->password = Hash::make($request->password);
    }
    $user->save();
    $user->syncRoles($request->roles ?? []);
    return redirect()->route('user.index')->with('success', 'User berhasil diupdate');
  }

  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();
    return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
  }
}
