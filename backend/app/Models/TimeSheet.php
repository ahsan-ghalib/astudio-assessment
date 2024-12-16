<?php

namespace App\Models;

use Database\Factories\TimeSheetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeSheet extends Model
{
    /** @use HasFactory<TimeSheetFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'task_name',
        'date',
        'hours',
    ];

    protected $casts = [
        'date' => 'date:d/m/Y',
        'hours' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
