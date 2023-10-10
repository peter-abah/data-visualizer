<?php

namespace App\Http\Requests;

use App\Enums\AggregationOption;
use App\Rules\ColumnInProject;
use App\Rules\ColumnIsNumeric;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class UpdateChartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // TODO: Write proper authorization logic
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'categoryColumn' => ['required', 'string', 'max:255', new ColumnInProject($this->chart->project)],
            'dataColumns' => 'array',
            'dataColumns.*' => ['string', 'max:255', new ColumnInProject($this->chart->project),
                new ColumnIsNumeric($this->chart->project)],
            'aggregationOption' => ['required', new Enum(AggregationOption::class)],
            'scaleType' => 'nullable|string',
            'dateFormat' => 'nullable|string',
            'removedColumns' => 'array',
            'removedColumns.*' => 'string|max:255',
        ];
    }

    public function after()
    {
        return [
            function (Validator $validator) {
                $dataColumnsNo = count($this->getDataColumns());
                if ($dataColumnsNo < 1) {
                    $validator->errors()->add(
                        'dataColumns',
                        'Data columns cannot be empty'
                    );
                }

                if ($dataColumnsNo > 3) {
                    $validator->errors()->add(
                        'dataColumns',
                        'Data columns must be less than 3'
                    );
                }
            },
        ];
    }

    public function getDataColumns(): array
    {
        // Filter removed data columns from chart columns
        $dataColumns = array_filter($this->chart->config['dataColumns'], function ($v) {
            return !in_array($v, $this->removedColumns ?? []);
        });

        // Merge added columns with filtered array
        return array_merge($dataColumns, $this->dataColumns ?? []);
    }
}
