<?php

namespace App\Filament\Resources\ExperienceCategoryResource\Pages;

use App\Filament\Resources\ExperienceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExperienceCategories extends ListRecords
{
    protected static string $resource = ExperienceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
