<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChartRequest;
use App\Models\Chart;
use App\Models\Project;
use App\Services\ChartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class ChartController extends Controller
{

    public function __construct(protected ChartService $chartService)
    {
        $this->authorizeResource(Chart::class, 'chart');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Project $project): View
    {
        return view("charts.create", [
            'project' => $project,
            'chartService' => $this->chartService,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChartRequest $request, Project $project): RedirectResponse
    {
        $chart = $this->chartService->createChart($request, $project);
        return redirect(route('charts.show', ['chart' => $chart]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chart $chart)
    {
        $chart->load('project');
        return Inertia::render('Chart', [
            'chart' => $chart,
            'linkToProject' => route('projects.show', $chart->project),
            'linkToSettings' => route('charts.edit', $chart),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chart $chart): View
    {
        return view('charts.edit', ['chart' => $chart]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chart $chart): RedirectResponse
    {
        $project = $chart->project;
        $chart->delete();
        return redirect(route('projects.show', ['project' => $project]));
    }
}
