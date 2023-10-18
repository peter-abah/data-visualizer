<?php

namespace App\Http\Controllers;

use App\Enums\ChartType;
use App\Http\Requests\Projects\StoreRequest;
use App\Http\Requests\Projects\UpdateRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct(protected ProjectService $projectService)
    {
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('dashboard', [
            'projects' => $request->user()->projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $project = $this->projectService->createProject($request);
        return redirect(route('projects.show', $project));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): View
    {
        $chartIcons = [];
        foreach (ChartType::cases() as $type) {
            $chartIcons[$type->value] = "icons.{$type->value}";
        }

        return view('projects.show', ['project' => $project, 'chartIcons' => $chartIcons]);
    }

    public function preview(Project $project): View
    {
        $this->authorize('view', $project);
        return view('projects.preview', ['project' => $project, 'data' => $project->loadData(100)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $project = $this->projectService->updateProject($request);
        return view('projects.show', ['project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect(route('dashboard'));
    }
}
