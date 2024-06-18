<?php

namespace App\Filament\Resources\ProductGalleryResource\Pages;

use App\Filament\Resources\ProductGalleryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductGallery extends CreateRecord
{
    protected static string $resource = ProductGalleryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
