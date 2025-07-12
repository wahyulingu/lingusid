<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Actions\Resident\CreateResidentAction;
use App\Actions\Resident\DeleteResidentAction;
use App\Actions\Resident\UpdateResidentAction;
use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Repositories\ResidentRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ResidentRepository $residentRepository)
    {
        $resident = $residentRepository->all();

        return Inertia::render('Dashboard/Sid/Resident/Index', [
            'resident' => $resident,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Sid/Resident/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateResidentAction $createResidentAction)
    {
        $validatedData = $request->validate([
            'nik' => 'required|unique:residents|max:255',
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $createResidentAction->handle($validatedData);

        return redirect()->route('resident.index')
            ->with('message', 'Resident data added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resident $resident)
    {
        return Inertia::render('Dashboard/Sid/Resident/Show', [
            'resident' => $resident,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        return Inertia::render('Dashboard/Sid/Resident/Edit', [
            'resident' => $resident,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resident $resident, UpdateResidentAction $updateResidentAction)
    {
        $validatedData = $request->validate([
            'nik' => 'required|unique:residents,nik,'.$resident->id.',id|max:255',
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $updateResidentAction->handle($resident, $validatedData);

        return redirect()->route('resident.index')
            ->with('message', 'Resident data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident, DeleteResidentAction $deleteResidentAction)
    {
        $deleteResidentAction->handle($resident);

        return redirect()->route('resident.index')
            ->with('message', 'Resident data deleted successfully.');
    }
}
