<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateChartRequest;
use App\Models\Chart;
use App\Services\ChartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
    public function sort(Request $request, Chart $chart) {

        $chart->data = $chart->sortDataByTime();
        $chart->update();
        return redirect(route('charts.show', ['chart' => $chart]));
    }
}
