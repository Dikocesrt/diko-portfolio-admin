<?php

namespace App\Filament\Resources\ProjectSkillResource\Pages;

use App\Filament\Resources\ProjectSkillResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateProjectSkill extends CreateRecord
{
    protected static string $resource = ProjectSkillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['id'])) {
            $data['id'] = Str::uuid()->toString();
        }

        return $data;
    }
}
