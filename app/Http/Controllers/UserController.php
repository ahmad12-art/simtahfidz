<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\LogActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(private LogActivityService $logService) {}

    public function index(Request $request)
    {
        $users = User::query()
            ->with('role')
            ->when($request->q, fn ($q) => $q->where('name', 'like', "%{$request->q}%")->orWhere('username', 'like', "%{$request->q}%"))
            ->when($request->role_id, fn ($q) => $q->where('role_id', $request->role_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $roles = Role::all();

        return view('user.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('user.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('user', 'public');
        }

        $user = User::create($data);

        $this->logService->catat("Menambahkan user: {$user->name}", 'user');

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (filled($data['password'] ?? null)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('user', 'public');
        }

        $user->update($data);

        $this->logService->catat("Memperbarui user: {$user->name}", 'user');

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $nama = $user->name;
        $user->delete();

        $this->logService->catat("Menghapus user: {$nama}", 'user');

        return back()->with('success', 'User berhasil dihapus.');
    }
}
