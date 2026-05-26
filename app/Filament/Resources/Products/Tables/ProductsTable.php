<?php

namespace App\Filament\Resources\Products\Tables;

use App\Catalog\Application\Products\PublishProductCommand;
use App\Catalog\Application\Products\PublishProductService;
use App\Catalog\Domain\Products\ProductCannotBePublished;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sku')->searchable()->sortable()->copyable(),
                TextColumn::make('name')->searchable()->sortable()->limit(40),
                TextColumn::make('category.name')->sortable()->toggleable(),
                TextColumn::make('unit.code')->sortable()->toggleable(),
                TextColumn::make('supplier.name')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')->money('KZT')->sortable(),
                TextColumn::make('stock')->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
            ])
            ->filters([
                SelectFilter::make('category_id')->relationship('category', 'name')->label('Category')->searchable()->preload(),
                TernaryFilter::make('is_active'),
            ])
            ->recordActions([
                Action::make('publish')
                    ->label('Publish')
                    ->requiresConfirmation()
                    ->visible(fn (Product $record): bool => $record->status !== 'published')
                    ->action(function (Product $record, PublishProductService $publishProduct): void {
                        try {
                            $publishProduct->handle(new PublishProductCommand(
                                productId: $record->id,
                                actorId: (int) auth()->id(),
                            ));

                            Notification::make()
                                ->title('Product published')
                                ->success()
                                ->send();
                        } catch (ProductCannotBePublished $exception) {
                            Notification::make()
                                ->title('Product cannot be published')
                                ->body($exception->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ])
            ->toolbarActions([]);
    }
}
