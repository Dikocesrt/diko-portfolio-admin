<?php

namespace App\Filament\Resources\ExperienceCategoryResource\Pages;

use App\Filament\Resources\ExperienceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateExperienceCategory extends CreateRecord
{
    protected static string $resource = ExperienceCategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['id'])) {
            $data['id'] = Str::uuid()->toString();
        }

        return $data;
    }
}
