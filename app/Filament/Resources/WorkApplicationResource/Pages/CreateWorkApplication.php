<?php

namespace App\Filament\Resources\WorkApplicationResource\Pages;

use App\Filament\Resources\WorkApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkApplication extends CreateRecord
{
    protected static string $resource = WorkApplicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
