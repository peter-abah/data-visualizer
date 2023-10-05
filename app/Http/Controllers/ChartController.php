<?php

namespace App\Http\Controllers;

use App\Enums\ChartType;
use App\Helpers\Helpers;
use App\Http\Requests\StoreChartRequest;
use App\Models\Chart;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class ChartController extends Controller
{
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChartRequest $request, Project $project): RedirectResponse
    {
        $validated = $request->validated();

        $chart = new Chart($validated);
        $chart->project()->associate($project);
        $chart->config = $chart->createConfig($validated);
        $chart->data = $chart->createData();

        $request->user()->charts()->save($chart);

        return redirect(route('charts.show', ['chart' => $chart]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chart $chart)
    {
        return Inertia::render('Chart', [
            'chart' => $chart
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chart $chart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chart $chart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chart $chart)
    {
        //
    }
}
