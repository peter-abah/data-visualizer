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
            'data-column' => 'required|max:255',
            'type' => 'required'
        ];
    }

    public function after(): array
    {
        return [
            // Validate column fields exist in project
            function (Validator $validator) {
                $column_fields = ['x-axis-column', 'data-column'];

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
                if (!$this->isColumnInProject('data-column')) {
                    return;
                }

                $csvFile = new CSVFile(Storage::path($this->project->file_path));
                $dataColumn = $this->input('data-column');

                foreach ($csvFile as $row) {
                    if (!is_numeric($row[$dataColumn])) {
                        $validator->errors()->add(
                            'data-column',
                            'data-column is not numeric'
                        );
                    }
                }
            }
        ];
    }

    private function isColumnInProject(string $columnAttribute): bool
    {
        return in_array($this->input($columnAttribute), $this->project->columns);
    }
}
