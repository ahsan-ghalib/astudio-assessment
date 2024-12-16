<?php

namespace App\Models;

use App\Enums\ProjectStatusEnum;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => ProjectStatusEnum::class,
    ];

    public function timeSheet(): HasMany
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function attributesValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
