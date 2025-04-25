<?php

namespace App\Filament\Resources\DocumentationResource\Pages;

use App\Filament\Resources\DocumentationResource;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditDocumentation extends EditRecord
{
    protected static string $resource = DocumentationResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => ['secure' => true]
        ]);

        $cloudinary = new Cloudinary();

        if (empty($data['image'])) {
            unset($data['image']);
        }else{
            $relativePath = $data['image'];
            $localPath = Storage::disk('public')->path($relativePath);

            if (file_exists($localPath)) {
                try {
                    $uploaded = $cloudinary->uploadApi()->upload($localPath, [
                        'folder' => 'documentations',
                    ]);

                    if (isset($uploaded['public_id'])) {
                        $data['image'] = $uploaded['public_id'];
                        Storage::disk('public')->delete($relativePath);
                    }
                } catch (\Exception $e) {
                    Log::error('Cloudinary upload failed (image)', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } else {
                Log::error('File not found (image)', ['path' => $localPath]);
            }
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
