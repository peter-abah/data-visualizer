<?php

namespace App\Http\Requests;

use App\Helpers\CSVFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
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
            'x-axis-column' => 'required|max:255',
            'data-columns' => 'array|required|min:1|max:3',
            'data-columns.*' => 'required|string|max:255',
            'type' => 'required'
        ];
    }

    public function after(): array
    {
        return [
            // Validate column fields exist in project
            function (Validator $validator) {
                // Validate X axis column in column
                $xAxisColumn = $this->input('x-axis-column');

                if (!$this->isColumnInProject($xAxisColumn)) {
                    $validator->errors()->add(
                        'x-axis-column',
                        "$xAxisColumn doesn't exist in project data"
                    );
                }

                // Validate data column
                $dataColumns = $this->input('data-columns');

                foreach ($dataColumns as $column) {
                    if (!$this->isColumnInProject($column)) {
                        $validator->errors()->add(
                            'data-columns',
                            "Data column ($column) doesn't exist in project data"
                        );
                    }
                }
            },

            // Validate data field is numeric
            function (Validator $validator)  {
                $dataColumns = $this->input('data-columns');
                if (!$dataColumns) return;

                $csvFile = new CSVFile(Storage::path($this->project->file_path));
                foreach ($csvFile as $row) {
                    foreach ($dataColumns as $column) {
                        if (!is_numeric($row[$column])) {
                            $validator->errors()->add(
                                'data-columns',
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
