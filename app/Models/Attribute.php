<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['attribute_group_id', 'name', 'code', 'type', 'sort_order'])]
class Attribute extends Model
{
    use HasFactory;

    public const TYPE_STRING = 'string';

    public const TYPE_INTEGER = 'integer';

    public const TYPE_DECIMAL = 'decimal';

    public const TYPE_BOOLEAN = 'boolean';

    public const TYPE_TEXT = 'text';

    public const TYPES = [
        self::TYPE_STRING,
        self::TYPE_INTEGER,
        self::TYPE_DECIMAL,
        self::TYPE_BOOLEAN,
        self::TYPE_TEXT,
    ];

    protected function casts(): array
    {
        return ['sort_order' => 'integer'];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class, 'attribute_group_id');
    }

    public function categoryAttributes(): HasMany
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
