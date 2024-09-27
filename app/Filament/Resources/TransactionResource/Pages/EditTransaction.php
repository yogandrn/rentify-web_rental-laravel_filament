<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
            
        ];
    }

    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index/list setelah edit
        return $this->getResource()::getUrl('index');
    }
}
