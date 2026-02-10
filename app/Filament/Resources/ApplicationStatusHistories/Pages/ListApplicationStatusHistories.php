<?php

namespace App\Filament\Resources\ApplicationStatusHistories\Pages;

use App\Filament\Resources\ApplicationStatusHistories\ApplicationStatusHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApplicationStatusHistories extends ListRecords
{
    protected static string $resource = ApplicationStatusHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
