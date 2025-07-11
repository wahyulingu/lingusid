<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Actions\Penduduk\CreatePendudukAction;
use App\Actions\Penduduk\DeletePendudukAction;
use App\Actions\Penduduk\UpdatePendudukAction;
use App\Models\Penduduk;
use App\Repositories\PendudukRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PendudukRepository $pendudukRepository)
    {
        $penduduk = $pendudukRepository->all();

        return Inertia::render('Penduduk/Index', [
            'penduduk' => $penduduk,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Penduduk/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreatePendudukAction $createPendudukAction)
    {
        $validatedData = $request->validate([
            'nik' => 'required|unique:penduduk|max:255',
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $createPendudukAction->handle($validatedData);

        return redirect()->route('penduduk.index')
            ->with('message', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penduduk $penduduk)
    {
        return Inertia::render('Penduduk/Show', [
            'penduduk' => $penduduk,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penduduk $penduduk)
    {
        return Inertia::render('Penduduk/Edit', [
            'penduduk' => $penduduk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penduduk $penduduk, UpdatePendudukAction $updatePendudukAction)
    {
        $validatedData = $request->validate([
            'nik' => 'required|unique:penduduk,nik,' . $penduduk->id . ',id|max:255',
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $updatePendudukAction->handle($penduduk, $validatedData);

        return redirect()->route('penduduk.index')
            ->with('message', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penduduk $penduduk, DeletePendudukAction $deletePendudukAction)
    {
        $deletePendudukAction->handle($penduduk);

        return redirect()->route('penduduk.index')
            ->with('message', 'Data penduduk berhasil dihapus.');
    }
}

