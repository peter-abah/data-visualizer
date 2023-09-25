<?php

namespace App\Models;

use App\Enums\ChartType;
use App\Helpers\CSVFile;
use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Chart extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => 'array',
        'config' => 'array',
        'type' => ChartType::class,
    ];

    public $fillable = ['name', 'type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function createData(Project $project, array $dataColumns, string $xAxisColumn)
    {
        $csvFile = new CSVFile(Storage::path($project->file_path));
        $data = [];

        foreach ($csvFile as $row) {
            $row = mb_convert_encoding($row, 'UTF-8', 'UTF-8');
            $key = $row["$xAxisColumn"];
            $dataColumnsRow = Helpers::extractKeysFromArray($row, $dataColumns);

            if (isset($data[$key])) {
                foreach ($dataColumnsRow as $column => $value) {
                    $data[$key][$column] += $value;
                }
            } else {
                $data[$key] = array_merge([
                    "$xAxisColumn" => $key
                ], $dataColumnsRow);
            }
        }

        return array_values($data);
    }
}
