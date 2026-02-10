<?php

namespace App\Filament\Resources\ApplicationStatusHistories\Pages;

use App\Filament\Resources\ApplicationStatusHistories\ApplicationStatusHistoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApplicationStatusHistory extends CreateRecord
{
    protected static string $resource = ApplicationStatusHistoryResource::class;
}
