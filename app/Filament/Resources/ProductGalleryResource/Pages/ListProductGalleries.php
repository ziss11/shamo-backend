<?php

namespace App\Filament\Resources\ProductGalleryResource\Pages;

use App\Filament\Resources\ProductGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductGalleries extends ListRecords
{
    protected static string $resource = ProductGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
