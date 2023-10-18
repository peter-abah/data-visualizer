<?php

namespace App\Models;

use App\Services\CSVFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $casts = [
        'columns' => 'array',
    ];
    public $fillable = ["name", "description"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function charts(): HasMany
    {
        return $this->hasMany(Chart::class);
    }

    public function loadData(int $numRows = 100): array
    {
        $result = [];
        $csvFile = new CSVFile(Storage::path($this->file_path));

        foreach ($csvFile as $row) {
            $result[] = $row;

            if (count($result) >= $numRows) break;
        }

        return $result;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Delete charts and data file on delete
        static::deleting(function (Project $project) {
            Storage::delete($project->file_path);
            $project->charts()->delete();
        });
    }
}
