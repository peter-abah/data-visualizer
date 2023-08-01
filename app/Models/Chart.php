<?php

namespace App\Models;

use App\Enums\ChartType;
use App\Helpers\CSVFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Chart extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => 'array',
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

    public function createData(Project $project, $dataColumn, $xAxisColumn)
    {
        $csvFile = new CSVFile(Storage::path($project->file_path));
        $data = [];

        foreach ($csvFile as $row) {
            array_push($data, [
                'dataColumn' => $row[$dataColumn],
                'xAxisColumn' => $row[$xAxisColumn]
            ]);
        }

        return $data;
    }
}
