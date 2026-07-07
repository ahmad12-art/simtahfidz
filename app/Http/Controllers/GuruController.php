<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guru\StoreGuruRequest;
use App\Http\Requests\Guru\UpdateGuruRequest;
use App\Models\Guru;
use App\Models\Role;
use App\Models\User;
use App\Services\LogActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function __construct(private LogActivityService $logService) {}

    public function index(Request $request)
    {
        $guru = Guru::query()
            ->search($request->q)
            ->applyFilters(['status' => $request->status])
            ->applySort($request->sort, $request->direction)
            ->paginate(10)
            ->withQueryString();

        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(StoreGuruRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->safe()->except(['foto', 'buat_akun', 'username', 'password']);

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('guru', 'public');
            }

            if ($request->boolean('buat_akun')) {
                $role = Role::where('slug', 'guru')->first();
                $user = User::create([
                    'name' => $request->nama,
                    'username' => $request->username,
                    'email' => $request->email ?: $request->username.'@simtahfidz.local',
                    'password' => Hash::make($request->password),
                    'role_id' => $role?->id,
                    'status' => 'aktif',
                ]);
                $data['user_id'] = $user->id;
            }

            $guru = Guru::create($data);

            $this->logService->catat("Menambahkan data guru: {$guru->nama}", 'guru');
        });

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        $guru->load(['kelasWali', 'targetHafalan.santri', 'setoran' => fn ($q) => $q->latest()->take(10)]);

        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, Guru $guru)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $data['foto'] = $request->file('foto')->store('guru', 'public');
        }

        $guru->update($data);

        $this->logService->catat("Memperbarui data guru: {$guru->nama}", 'guru');

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $nama = $guru->nama;
        $guru->delete();

        $this->logService->catat("Menghapus data guru: {$nama}", 'guru');

        return back()->with('success', 'Data guru berhasil dihapus.');
    }
}
