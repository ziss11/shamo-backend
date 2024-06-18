<?php

namespace App\Filament\Resources\TransactionDetailResource\Pages;

use App\Filament\Resources\TransactionDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionDetail extends EditRecord
{
    protected static string $resource = TransactionDetailResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
