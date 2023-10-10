<?php

namespace App\Http\Requests;

use App\Enums\AggregationOption;
use App\Rules\ColumnInProject;
use App\Rules\ColumnIsNumeric;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'categoryColumn' => ['required', 'string', 'max:255', new ColumnInProject($this->project)],
            'dataColumns' => 'array|required|min:1|max:3',
            'dataColumns.*' => ['required', 'string', 'max:255', new ColumnInProject($this->project), new ColumnIsNumeric($this->project)],
            'type' => 'required',
            'aggregationOption' => ['required', new Enum(AggregationOption::class)],
            'scaleType' => 'nullable|string',
            'dateFormat' => 'nullable|string',
        ];
    }
}
