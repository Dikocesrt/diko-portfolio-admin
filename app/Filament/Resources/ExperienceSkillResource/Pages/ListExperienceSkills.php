<?php

namespace App\Filament\Resources\ExperienceSkillResource\Pages;

use App\Filament\Resources\ExperienceSkillResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExperienceSkills extends ListRecords
{
    protected static string $resource = ExperienceSkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
