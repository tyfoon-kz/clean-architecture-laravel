<?php

namespace App\Filament\Resources\CategoryAttributes\Pages;

use App\Filament\Resources\CategoryAttributes\CategoryAttributeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCategoryAttribute extends EditRecord
{
    protected static string $resource = CategoryAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
