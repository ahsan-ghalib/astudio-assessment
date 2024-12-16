<?php

namespace App\Models;

use App\Enums\AttributeTypeEnum;
use Database\Factories\EntityAttributeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EntityAttribute extends Model
{
    /** @use HasFactory<EntityAttributeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    protected $casts = [
        'type' => AttributeTypeEnum::class,
    ];

    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
