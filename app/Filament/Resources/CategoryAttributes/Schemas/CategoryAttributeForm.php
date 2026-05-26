<?php

namespace App\Filament\Resources\CategoryAttributes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryAttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')->label('Category')->relationship('category', 'name')->searchable()->preload()->required(),
                Select::make('attribute_id')->label('Attribute')->relationship('attribute', 'name')->searchable()->preload()->required(),
                Toggle::make('is_required')->label('Required')->default(false),
                Toggle::make('is_filterable')->label('Used in filters')->default(false),
                TextInput::make('sort_order')->label('Order')->integer()->default(0)->minValue(0),
            ]);
    }
}
