<?php

namespace App\Filament\Resources\ExperienceSkillResource\Pages;

use App\Filament\Resources\ExperienceSkillResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateExperienceSkill extends CreateRecord
{
    protected static string $resource = ExperienceSkillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['id'])) {
            $data['id'] = Str::uuid()->toString();
        }

        return $data;
    }
}
