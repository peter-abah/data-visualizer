<?php

namespace App\Models;

use App\Enums\AggregationOption;
use App\Enums\ChartType;
use App\Services\CSVFile;
use App\Services\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function createData(): array
    {
        $csvFile = new CSVFile(Storage::path($this->project->file_path));
        $xAxisColumn = $this->config['xAxisColumn'];
        $dataColumns = $this->config['dataColumns'];
        $data = [];
        $keyCount = [];

        foreach ($csvFile as $row) {
            $row = mb_convert_encoding($row, 'UTF-8', 'UTF-8');
            $key = $row["$xAxisColumn"];
            $dataColumnsRow = Helpers::filterKeysInArray($row, $dataColumns);

            if (isset($data[$key])) {
                foreach ($dataColumnsRow as $column => $value) {
                    $data[$key][$column] += $value;
                }
                $keyCount[$key] += 1;
            } else {
                $data[$key] = array_merge([
                    "$xAxisColumn" => $key
                ], $dataColumnsRow);
                $keyCount[$key] = 1;
            }
        }

        if ($this->config['aggregationOption'] == AggregationOption::Average->value) {
            $data = $this->aggregateAverage($data, $keyCount);
        }

        return array_values($data);
    }

    public function createConfig(array $validated): array
    {
        return Helpers::filterKeysInArray($validated, ['dataColumns', 'xAxisColumn', 'aggregationOption']);
    }

    private function aggregateAverage(array $data, array $keyCount): array
    {
        foreach ($keyCount as $key => $count) {
            foreach ($this->config['dataColumns'] as $dataColumn) {
                $data[$key][$dataColumn] /= $count;
            }
        }

        return $data;
    }
}
