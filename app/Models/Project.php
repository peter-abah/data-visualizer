<?php

namespace App\Models;

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
