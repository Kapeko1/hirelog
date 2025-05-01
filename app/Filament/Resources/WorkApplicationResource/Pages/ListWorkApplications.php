<?php

namespace App\Filament\Resources\WorkApplicationResource\Pages;

use App\Filament\Resources\WorkApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkApplications extends ListRecords
{
    protected static string $resource = WorkApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
