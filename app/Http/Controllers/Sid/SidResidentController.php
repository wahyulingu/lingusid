<?php

namespace App\Http\Controllers\Sid;

use App\Actions\Sid\Resident\CreateSidResidentAction;
use App\Actions\Sid\Resident\DeleteSidResidentAction;
use App\Actions\Sid\Resident\GetSidResidentsAction;
use App\Actions\Sid\Resident\UpdateSidResidentAction;
use App\Http\Controllers\Controller;
use App\Models\Sid\SidResident;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SidResidentController extends Controller
{
    public function __construct(
        protected GetSidResidentsAction $getSidResidentsAction,
        protected CreateSidResidentAction $createSidResidentAction,
        protected UpdateSidResidentAction $updateSidResidentAction,
        protected DeleteSidResidentAction $deleteSidResidentAction
    ) {}

    public function index()
    {
        return Inertia::render('Sid/Population/Residents/Index', [
            'residents' => $this->getSidResidentsAction->handle(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Sid/Population/Residents/Create');
    }

    public function store(Request $request)
    {
        $this->createSidResidentAction->handle($request->all());

        return redirect()->route('dashboard.sid.population.residents.index');
    }

    public function edit(SidResident $resident)
    {
        return Inertia::render('Sid/Population/Residents/Edit', [
            'resident' => $resident,
        ]);
    }

    public function update(Request $request, SidResident $resident)
    {
        $this->updateSidResidentAction->handle([
            'resident' => $resident,
        ] + $request->all());

        return redirect()->route('dashboard.sid.population.residents.index');
    }

    public function destroy(SidResident $resident)
    {
        $this->deleteSidResidentAction->handle($resident);

        return redirect()->route('dashboard.sid.population.residents.index');
    }
}
