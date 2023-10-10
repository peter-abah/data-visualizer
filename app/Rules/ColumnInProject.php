<?php

namespace App\Rules;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ColumnInProject implements ValidationRule
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
        if (!in_array($value, $this->project->columns)) {
            $fail("Column ($value) does not exist in project data");
        }
    }
}
