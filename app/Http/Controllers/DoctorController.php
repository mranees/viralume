<?php

namespace App\Http\Controllers;

use App\Http\Requests\Doctor\DoctorStoreFormRequest;
use App\Http\Requests\Doctor\DoctorUpdateFormRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\SpecializationResource;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Services\DoctorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class DoctorController extends Controller
{

    protected DoctorService $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $doctors = $this->doctorService->index($request);

        return inertia('Doctors/index', [
            'doctors' => $doctors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $specializations = Specialization::all('id', 'name');

        // dd($specialities);
        return inertia('Doctors/create', [
            'specializations' => $specializations,
            'doctor' => new Doctor,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorStoreFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->doctorService->store($validated);

        $lastpage = (int) ceil(Doctor::count() / 10);

        return redirect()->route('doctors.index', ['page' => $lastpage])->with('message', 'Doctor created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor): Response
    {
        return inertia('Doctors/show', [
            'doctor' => new DoctorResource($doctor)->resolve(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor): Response
    {
        $specializations = SpecializationResource::collection(Specialization::all())->resolve();

        return inertia('Doctors/edit', [
            'specializations' => $specializations,
            'doctor' => new DoctorResource($doctor)->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorUpdateFormRequest $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validated();
        $this->doctorService->update($doctor, $validated);

        return redirect()->route('doctors.index')->with('message', 'Doctor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor): RedirectResponse
    {
        $this->doctorService->delete($doctor);

        return back()->with('message', 'Doctor deleted successfully');
    }
}
