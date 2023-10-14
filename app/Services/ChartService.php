<?php

namespace App\Services;

use App\Http\Requests\StoreChartRequest;
use App\Http\Requests\UpdateChartRequest;
use App\Models\Chart;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

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

    public function updateChart(UpdateChartRequest $request)
    {
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

    public function checkConfigIsValid(Chart $chart): array
    {
        // Check category column is in project
        $categoryColumn = $chart->config['categoryColumn'];
        if (!in_array($categoryColumn, $chart->project->columns)) {
            return [false, "Column ($categoryColumn) does not exist in project data."];
        }

        // Check data columns is in project
        foreach ($chart->config['dataColumns'] as $column) {
            if (!in_array($column, $chart->project->columns)) {
                return [false, "Column ($column) does not exist in project data."];
            }
        }

        // Check data columns are numeric
        $csvFile = new CSVFile(Storage::path($chart->project->file_path));
        foreach ($csvFile as $row) {
            foreach ($chart->config['dataColumns'] as $column) {
                if (!is_numeric($row[$column] ?? '')) {
                    return [false, "Column ($column) contains non numeric value(s)."];
                }
            }
        }

        return [true, null];
    }
}
