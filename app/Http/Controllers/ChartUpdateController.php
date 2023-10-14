<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateChartRequest;
use App\Models\Chart;
use App\Services\ChartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChartUpdateController extends Controller
{
    public function __construct(protected ChartService $chartService)
    {}

    // Updates normal chart fields
    public function update(UpdateChartRequest $request, Chart $chart): RedirectResponse
    {
        $chart = $this->chartService->updateChart($request);
        return redirect(route('charts.show', ['chart' => $chart]));
    }

    // Sorts chart data using date
    public function sort(Request $request, Chart $chart)
    {

        $chart->data = $chart->sortDataByTime();
        $chart->update();
        return redirect(route('charts.show', ['chart' => $chart]));
    }

    // Builds chart data from config. Useful for changed project data
    public function rebuildData(Request $request, Chart $chart)
    {
        $validator = Validator::make([], []);
        $validator->after(function (\Illuminate\Validation\Validator $validator) use ($chart) {
            $isValid = $this->chartService->checkConfigIsValid($chart);
            if (!$isValid[0]) {
                $validator->errors()->add('rebuildData', $isValid[1]);
                $validator->errors()->add('rebuildData', "Update chart columns before rebuilding data.");
            }
        });
        $validator->validate();

        $chart->data = $chart->createData();
        $chart->update();
        return redirect(route('charts.show', ['chart' => $chart]));
    }

    public function updateConfig(Request $request, Chart $chart)
    {
        $attributes = $request->validate([
            'sectorLimit' => 'numeric|min:2|nullable',
        ]);

        $chart->config = array_merge($chart->config, $chart->createConfig($attributes));
        $chart->update();
        return redirect(route('charts.show', ['chart' => $chart]));
    }
}
