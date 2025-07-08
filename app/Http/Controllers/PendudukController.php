<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penduduk = Penduduk::all();
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
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:penduduk|max:255',
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        Penduduk::create($request->all());

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
    public function update(Request $request, Penduduk $penduduk)
    {
        $request->validate([
            'nik' => 'required|unique:penduduk,nik,' . $penduduk->id . ',id|max:255',
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $penduduk->update($request->all());

        return redirect()->route('penduduk.index')
            ->with('message', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();

        return redirect()->route('penduduk.index')
            ->with('message', 'Data penduduk berhasil dihapus.');
    }
}
