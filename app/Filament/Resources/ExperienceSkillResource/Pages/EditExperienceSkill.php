<?php

namespace App\Filament\Resources\ExperienceSkillResource\Pages;

use App\Filament\Resources\ExperienceSkillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExperienceSkill extends EditRecord
{
    protected static string $resource = ExperienceSkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
