<?php

namespace App\Filament\Resources\ProjectSkillResource\Pages;

use App\Filament\Resources\ProjectSkillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectSkill extends EditRecord
{
    protected static string $resource = ProjectSkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
