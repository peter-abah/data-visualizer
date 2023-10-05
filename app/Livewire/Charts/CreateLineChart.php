<?php

namespace App\Livewire\Charts;

use App\Enums\ChartType;
use App\Helpers\CSVFile;
use App\Models\Chart;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateLineChart extends Component
{
    public Project $project;

    #[Rule('required|max:255', onUpdate: false)]
    public string $name = '';

    #[Rule('required|max:255', as: 'Category column', onUpdate: false)]
    public string $categoryColumn = '';

    #[Rule('required|array|min:1', as: 'Data column', onUpdate: false)]
    public array $dataColumns = [];

    public int $dataColumnsNo = 1;

    protected function rules()
    {
        return [
            'dataColumns.*' => 'required|string|max:255'
        ];
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {
            $validator->after([
                // Validate field exist in data
                function (Validator $validator) {
                    // Check Category column
                    if (!$this->isColumnInProject($this->categoryColumn)) {
                        $validator->errors()->add(
                            'categoryColumn',
                            "$this->categoryColumn doesn't exist in project data"
                        );
                    }

                    // Check data columns
                    foreach ($this->dataColumns as $column) {
                        if (!$this->isColumnInProject($column)) {
                            $validator->errors()->add(
                                'dataColumns',
                                "$column doesn't exist in project data"
                            );
                        }
                    }
                },

                // Validate data field is numeric
                function (Validator $validator) {
                    $csvFile = new CSVFile(Storage::path($this->project->file_path));

                    foreach ($csvFile as $row) {
                        foreach ($this->dataColumns as $column) {
                            if (!$this->isColumnInProject($column)) continue;

                            if (!is_numeric($row[$column])) {
                                $validator->errors()->add(
                                    'dataColumns',
                                    "Data column ($column) is not numeric"
                                );
                            }
                        }
                    }
                }
            ]);
        });
    }

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {

        return view('livewire.charts.create-line-chart');
    }

    public function save(Request $request)
    {
        dd($this->all());
        $validated = $this->validate();
        dd($validated);
        $chart = new Chart($validated);
        $chart->type = ChartType::LineChart;

        $chart->project()->associate($this->project);

        $chartData = $chart->createData(
            $this->project,
            $validated['dataColumn'],
            $validated['categoryColumn']
        );
        $chart->data = $chartData;

        $chart->config = [
            'dataColumn' => $validated['dataColumn'],
            'categoryColumn' => $validated['categoryColumn']
        ];

        Auth::user()->charts()->save($chart);

        return redirect(route('charts.show', ['chart' => $chart]));
    }

    private function isColumnInProject(string $column): bool
    {

        return in_array($column, $this->project->columns);
    }
}
