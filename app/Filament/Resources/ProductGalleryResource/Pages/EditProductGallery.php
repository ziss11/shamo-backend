<?php

namespace App\Filament\Resources\ProductGalleryResource\Pages;

use App\Filament\Resources\ProductGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductGallery extends EditRecord
{
    protected static string $resource = ProductGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
