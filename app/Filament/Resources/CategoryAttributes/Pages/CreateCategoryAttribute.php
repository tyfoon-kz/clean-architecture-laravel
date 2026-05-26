<?php

namespace App\Filament\Resources\CategoryAttributes\Pages;

use App\Filament\Resources\CategoryAttributes\CategoryAttributeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryAttribute extends CreateRecord
{
    protected static string $resource = CategoryAttributeResource::class;
}
