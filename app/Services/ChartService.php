<?php

namespace App\Services;

use App\Http\Requests\StoreChartRequest;
use App\Http\Requests\UpdateChartRequest;
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

    public function updateChart(UpdateChartRequest $request) {
        $chart = $request->chart;
        $attributes = $request->validated();

        $hasColumnsChanged = $attributes['categoryColumn'] !== $chart->config['categoryColumn']
            || ($attributes['removedColumns'] ?? false)
            || ($attributes['dataColumns'] ?? false);

        $chart->config = array_merge($chart->config, $chart->createConfig([...$attributes,
            'dataColumns' => $request->getDataColumns()])
        );

        if ($hasColumnsChanged) {
            $chart->data = $chart->createData();
        }

        $chart->update($attributes);

        return $chart;
    }
}
