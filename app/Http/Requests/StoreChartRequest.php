<?php

namespace App\Http\Requests;

use App\Enums\AggregationOption;
use App\Services\CSVFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class StoreChartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'xAxisColumn' => 'required|max:255',
            'dataColumns' => 'array|required|min:1|max:3',
            'dataColumns.*' => 'required|string|max:255',
            'type' => 'required',
            'aggregationOption' => ['required', new Enum(AggregationOption::class)],
        ];
    }

    public function after(): array
    {
        return [
            // Validate column fields exist in project
            function (Validator $validator) {
                // Validate X axis column in column
                $xAxisColumn = $this->input('xAxisColumn');

                if (!$this->isColumnInProject($xAxisColumn)) {
                    $validator->errors()->add(
                        'xAxisColumn',
                        "$xAxisColumn doesn't exist in project data"
                    );
                }

                // Validate data column
                $dataColumns = $this->input('dataColumns');

                foreach ($dataColumns as $column) {
                    if (!$this->isColumnInProject($column)) {
                        $validator->errors()->add(
                            'dataColumns',
                            "Data column ($column) doesn't exist in project data"
                        );
                    }
                }
            },

            // Validate data field is numeric
            function (Validator $validator) {
                $dataColumns = $this->input('dataColumns');
                if (!$dataColumns)
                    return;

                $csvFile = new CSVFile(Storage::path($this->project->file_path));
                foreach ($csvFile as $row) {
                    foreach ($dataColumns as $column) {
                        if (!is_numeric($row[$column])) {
                            $validator->errors()->add(
                                'dataColumns',
                                "Data column ($column) is not numeric"
                            );
                        }
                    }
                }
            }
        ];
    }

    private function isColumnInProject(string $column): bool
    {
        return in_array($column, $this->project->columns);
    }
}
