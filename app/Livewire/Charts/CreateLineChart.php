<?php

namespace App\Livewire\Charts;

use App\Enums\ChartType;
use App\Helpers\CSVFile;
use App\Models\Chart;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateLineChart extends Component
{
    public Project $project;

    #[Rule('required|max:255', onUpdate: false)]
    public string $name = '';

    #[Rule('required|max:255', as: 'X axis column', onUpdate: false)]
    public string $xAxisColumn = '';

    #[Rule('required|max:255', as: 'Data column', onUpdate: false)]
    public string $dataColumn = '';

    public function boot()
    {
        $this->withValidator(function ($validator) {
            $validator->after([
                // Validate field exist in data
                function (Validator $validator) {
                    $column_fields = ['xAxisColumn', 'dataColumn'];

                    foreach ($column_fields as $field) {
                        if (!$this->isColumnInProject($field)) {
                            $validator->errors()->add(
                                $field,
                                "$field doesn't exist in project data"
                            );
                        }
                    }
                },

                // Validate data field is numeric
                function (Validator $validator) {
                    if (!$this->isColumnInProject('dataColumn')) {
                        return;
                    }

                    $csvFile = new CSVFile(Storage::path($this->project->file_path));

                    foreach ($csvFile as $row) {
                        if (!is_numeric($row[$this->dataColumn])) {
                            $validator->errors()->add(
                                'dataColumn',
                                'Data column is not numeric'
                            );
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

    public function save()
    {
        $validated = $this->validate();
        $chart = new Chart($validated);
        $chart->type = ChartType::LineChart;

        $chart->project()->associate($this->project);

        $chartData = $chart->createData(
            $this->project,
            $validated['dataColumn'],
            $validated['xAxisColumn']
        );
        $chart->data = $chartData;

        $chart->config = [
            'dataColumn' => $validated['dataColumn'],
            'xAxisColumn' => $validated['xAxisColumn']
        ];

        Auth::user()->charts()->save($chart);

        return redirect(route('charts.show', ['chart' => $chart]));
    }

    private function isColumnInProject(string $field): bool
    {

        return in_array($this->getPropertyValue($field), $this->project->columns);
    }
}
