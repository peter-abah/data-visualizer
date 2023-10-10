<?php

namespace App\Rules;

use App\Models\Project;
use App\Services\CSVFile;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class ColumnIsNumeric implements ValidationRule
{
    public function __construct(protected Project $project)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $csvFile = new CSVFile(Storage::path($this->project->file_path));
        foreach ($csvFile as $row) {
            if (!is_numeric($row[$value] ?? '')) {
                $fail("Column ($value) contains non numeric value(s)");
            }
        }
    }
}
