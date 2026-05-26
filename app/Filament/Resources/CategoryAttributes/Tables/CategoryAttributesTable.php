<?php

namespace App\Filament\Resources\CategoryAttributes\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CategoryAttributesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')->label('Category')->searchable()->sortable(),
                TextColumn::make('attribute.name')->label('Attribute')->searchable()->sortable(),
                TextColumn::make('attribute.type')->label('Value type')->badge()->sortable(),
                IconColumn::make('is_required')->label('Required')->boolean()->sortable(),
                IconColumn::make('is_filterable')->label('Used in filters')->boolean()->sortable(),
                TextColumn::make('sort_order')->label('Order')->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')->label('Category')->relationship('category', 'name')->searchable()->preload(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ])
            ->toolbarActions([]);
    }
}
