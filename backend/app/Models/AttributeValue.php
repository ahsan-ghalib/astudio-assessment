<?php

namespace App\Models;

use Database\Factories\AttributeValueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeValue extends Model
{
    /** @use HasFactory<AttributeValueFactory> */
    use HasFactory;

    protected $fillable = [
        'entity_id',
        'entity_attribute_id',
        'value',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(EntityAttribute::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'entity_id');
    }
}
