<?php

namespace App\Http\Controllers;

use App\Http\Requests\Patient\PatientStoreFormRequest;
use App\Http\Requests\Patient\PatientUpdateFormRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }
    public function index(Request $request)
    {
        $patients = $this->patientService->index($request);

        return inertia('Patients/index', [
            'patients' => $patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Patients/create', [
            'patient' => new Patient,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientStoreFormRequest $request)
    {
        $validated = $request->validated();

        $this->patientService->store($validated);

        return redirect()->route('patients.index')->with('message', 'Patient created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return inertia('Patients/show', [
            'patient' => new PatientResource($patient)->resolve(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return inertia('Patients/edit', [
            'patient' => new PatientResource($patient)->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientUpdateFormRequest $request, Patient $patient)
    {
        $validated = $request->validated();

        $this->patientService->update($patient, $validated);

        return redirect()->route('patients.index')->with('message', 'Patient updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return back()->with('message', 'Patient deleted successfully');
    }
}
