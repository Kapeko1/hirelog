<?php

namespace App\Filament\Resources\ApplicationStatusHistories\Pages;

use App\Filament\Resources\ApplicationStatusHistories\ApplicationStatusHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApplicationStatusHistory extends EditRecord
{
    protected static string $resource = ApplicationStatusHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->modalHeading(__('app.confirm_bulk_delete'))
                ->modalDescription(''),
        ];
    }
}
