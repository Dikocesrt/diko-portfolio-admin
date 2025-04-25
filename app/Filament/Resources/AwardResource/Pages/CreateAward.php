<?php

namespace App\Filament\Resources\AwardResource\Pages;

use App\Filament\Resources\AwardResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateAward extends CreateRecord
{
    protected static string $resource = AwardResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['id'])) {
            $data['id'] = Str::uuid()->toString();
        }

        return $data;
    }
}
