<?php

namespace App\Http\Controllers\Dashboard\Sid;

use App\Actions\Sid\Resident\CreateResidentAction;
use App\Actions\Sid\Resident\DeleteResidentAction;
use App\Actions\Sid\Resident\UpdateResidentAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\SidResident;
use App\Repositories\Sid\SidResidentRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SidResidentRepository $sidResidentRepository)
    {
        $resident = $sidResidentRepository->all();

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

        return redirect()->route('dashboard.sid.resident.index')
            ->with('message', 'Resident data added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SidResident $resident)
    {
        return Inertia::render('Dashboard/Sid/Resident/Show', [
            'resident' => $resident,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SidResident $resident)
    {
        return Inertia::render('Dashboard/Sid/Resident/Edit', [
            'resident' => $resident,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SidResident $resident, UpdateResidentAction $updateResidentAction)
    {
        $validatedData = $request->validate([
            'nik' => 'required|unique:residents,nik,'.$resident->id.',id|max:255',
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $updateResidentAction->handle($resident, $validatedData);

        return redirect()->route('dashboard.sid.resident.index')
            ->with('message', 'Resident data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SidResident $resident, DeleteResidentAction $deleteResidentAction)
    {
        $deleteResidentAction->handle($resident);

        return redirect()->route('dashboard.sid.resident.index')
            ->with('message', 'Resident data deleted successfully.');
    }
}
