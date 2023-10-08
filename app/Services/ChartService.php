<?php

namespace App\Services;

use App\Http\Requests\StoreChartRequest;
use App\Models\Chart;
use App\Models\Project;

class ChartService
{
    public function createChart(StoreChartRequest $request, Project $project)
    {
        $chart = new Chart($request->validated());
        $chart->project()->associate($project);
        $chart->data = $chart->createData();

        $request->user()->charts()->save($chart);

        return $chart;
    }
}
