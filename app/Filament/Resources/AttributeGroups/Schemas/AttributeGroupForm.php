<?php

namespace App\Filament\Resources\AttributeGroups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttributeGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Name')->required()->maxLength(255),
                TextInput::make('code')->label('Code')->required()->maxLength(64)->unique(ignoreRecord: true),
                TextInput::make('sort_order')->label('Order')->integer()->default(0)->minValue(0),
            ]);
    }
}
