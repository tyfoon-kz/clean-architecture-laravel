<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Main')->schema([
                    TextInput::make('sku')->required()->maxLength(64)->unique(ignoreRecord: true),
                    TextInput::make('name')->required()->maxLength(255),
                    Textarea::make('description')->maxLength(5000)->columnSpanFull(),
                    Toggle::make('is_active')->default(true),
                ])->columns(2),
                Section::make('Classification')->schema([
                    Select::make('category_id')->relationship('category', 'name')->searchable()->preload()->required(),
                    Select::make('unit_id')->relationship('unit', 'name')->searchable()->preload()->required(),
                    Select::make('supplier_id')->relationship('supplier', 'name')->searchable()->preload(),
                ])->columns(3),
                Section::make('Commercial')->schema([
                    TextInput::make('price')->numeric()->required()->minValue(0)->prefix('KZT'),
                    TextInput::make('stock')->integer()->required()->minValue(0),
                ])->columns(2),
            ]);
    }
}
