<?php

namespace App\Http\Controllers;

use App\Http\Requests\Specialization\SpecializationStoreFormRequest;
use App\Http\Requests\Specialization\SpecializationUpdateFormRequest;
use App\Models\Specialization;
use App\Services\SpecializationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class SpecializationController extends Controller
{
    protected SpecializationService $specializationService;

    public function __construct(SpecializationService $specializationService)
    {
        $this->specializationService = $specializationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $specializations = $this->specializationService->index($request);

        return inertia('Specializations/index', [
            'specializations' => $specializations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return inertia('Specializations/create', [
            'specialization' => new Specialization,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecializationStoreFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->specializationService->store($validated);
        $lastpage = (int) ceil(Specialization::count() / 10);

        return redirect()->route('specializations.index', ['page' => $lastpage])->with('message', 'Specialization created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialization $specialization): Response
    {
        return inertia('Specializations/edit', [
            'specialization' => $specialization,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecializationUpdateFormRequest $request, Specialization $specialization): RedirectResponse
    {
        $validated = $request->validated();
        $this->specializationService->update($specialization, $validated);

        return redirect()->route('specializations.index')->with('message', 'Specialization updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialization $specialization): RedirectResponse
    {
        $this->specializationService->delete($specialization);

        return back()->with('message', 'Specialization deleted successfully');
    }
}
