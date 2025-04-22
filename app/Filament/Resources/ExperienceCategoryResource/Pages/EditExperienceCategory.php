<?php

namespace App\Filament\Resources\ExperienceCategoryResource\Pages;

use App\Filament\Resources\ExperienceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExperienceCategory extends EditRecord
{
    protected static string $resource = ExperienceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
