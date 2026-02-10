<?php

namespace App\Filament\Resources\WorkApplicationResource\Pages;

use App\Filament\Resources\WorkApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkApplication extends EditRecord
{
    protected static string $resource = WorkApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->modalHeading(__('app.confirm_bulk_delete'))
                ->modalDescription(''),
        ];
    }
}
