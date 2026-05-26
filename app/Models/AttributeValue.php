<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'product_id',
    'attribute_id',
    'value_string',
    'value_integer',
    'value_decimal',
    'value_boolean',
    'value_text',
])]
class AttributeValue extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'value_integer' => 'integer',
            'value_decimal' => 'decimal:3',
            'value_boolean' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function hasFilledValue(): bool
    {
        return $this->value_string !== null
            || $this->value_integer !== null
            || $this->value_decimal !== null
            || $this->value_boolean !== null
            || $this->value_text !== null;
    }
}
