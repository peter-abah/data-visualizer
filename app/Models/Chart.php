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

    protected $configKeys = [
        'dataColumns',
        'categoryColumn',
        'aggregationOption',
        'scaleType',
        'dateFormat',
    ];

    protected bool $hasColumnsChanged = false;

    public $fillable = ['name', 'type'];

    public function __construct(array $attributes = [])
    {
        $this->config = $this->createConfig($attributes);
        parent::__construct($attributes);
    }

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
        $data = $this->generateData();
        $data = $this->aggregateData($data);
        $data = $this->modifyDataByType($data);

        return array_values($data);
    }

    public function createConfig(array $attributes): array
    {
        return Helpers::filterKeysInArray($attributes, $this->configKeys);
    }

    private function generateData(): array
    {
        $data = [];
        $csvFile = new CSVFile(Storage::path($this->project->file_path));
        $categoryColumn = $this->config['categoryColumn'];
        $dataColumns = $this->config['dataColumns'];

        foreach ($csvFile as $row) {
            $key = $row["$categoryColumn"];
            $row = mb_convert_encoding($row, 'UTF-8', 'UTF-8');
            $row = Helpers::filterKeysInArray($row, [...$dataColumns, $categoryColumn]);

            if (isset($data[$key])) {
                foreach ($dataColumns as $column) {
                    if (is_array($data[$key][$column])) {
                        array_push($data[$key][$column], $row[$column]);
                    } else {
                        $data[$key][$column] = [$data[$key][$column], $row[$column]];
                    }
                }
            } else {
                $data[$key] = $row;
            }
        }

        return $data;
    }

    private function aggregateData(array $data): array
    {
        switch ($this->config['aggregationOption']) {
            case AggregationOption::Average->value:
                return $this->aggregateAverage($data);
            case AggregationOption::Sum->value:
                return $this->aggregateSum($data);
            default:
                return $this->aggregateSum($data);
        }
    }

    private function aggregateAverage(array $data): array
    {
        foreach ($data as $key => $row) {
            foreach ($this->config['dataColumns'] as $column) {
                $v = $data[$key][$column];
                if (is_array($v)) {
                    $data[$key][$column] = array_sum($v) / count($v);
                }

            }
        }

        return $data;
    }

    private function aggregateSum(array $data): array
    {
        foreach ($data as $key => $row) {
            foreach ($this->config['dataColumns'] as $column) {
                $v = $data[$key][$column];
                if (is_array($v)) {
                    $data[$key][$column] = array_sum($v);
                }

            }
        }

        return $data;
    }

    private function modifyDataByType(array $data): array
    {
        switch ($this->type) {
            case ChartType::PieChart:
                // Sort data by data column in descending order if chart type is pie chart
                uasort($data, function ($a, $b) {
                    $dataColumns = $this->config['dataColumns'];
                    return $b["$dataColumns[0]"] - $a["$dataColumns[0]"];
                });
                return $data;
            default:
                return $data;
        }
    }
}
