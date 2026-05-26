<?php

namespace App\Filament\Resources\Attributes\Schemas;

use App\Models\Attribute;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('attribute_group_id')
                    ->label('Group')
                    ->relationship('group', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('name')->label('Name')->required()->maxLength(255),
                TextInput::make('code')->label('Code')->required()->maxLength(64)->unique(ignoreRecord: true),
                Select::make('type')
                    ->label('Value type')
                    ->options(array_combine(Attribute::TYPES, Attribute::TYPES))
                    ->required(),
                TextInput::make('sort_order')->label('Order')->integer()->default(0)->minValue(0),
            ]);
    }
}
