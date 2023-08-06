<?php

namespace App\Http\Controllers;

use App\Enums\ChartType;
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
        $chartType = $request->input('type') ?? ChartType::LineChart;

        return view("charts.create.$chartType", [
            'project' => $project,
            'columns' => $project->columns,
            'chartType' => $chartType,
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

        $chartData = $chart->createData(
            $project,
            $validated['data-column'],
            $validated['x-axis-column']
        );
        $chart->data = $chartData;

        $chart->config = [
            'dataColumn' => $validated['data-column'],
            'xAxisColumn' => $validated['x-axis-column']
        ];

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
