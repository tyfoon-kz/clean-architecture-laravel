<?php

namespace App\Filament\Resources\CategoryAttributes\Pages;

use App\Filament\Resources\CategoryAttributes\CategoryAttributeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategoryAttributes extends ListRecords
{
    protected static string $resource = CategoryAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
