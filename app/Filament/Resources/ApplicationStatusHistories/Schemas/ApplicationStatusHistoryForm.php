<?php

namespace App\Filament\Resources\ApplicationStatusHistories\Schemas;

use App\Enums\ApplicationStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ApplicationStatusHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('work_application_id')
                    ->relationship(
                        'workApplication',
                        'company_name',
                        fn($query) => $query->where('user_id', auth()->id())
                    )
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->company_name} - {$record->position}")
                    ->searchable(['company_name', 'position'])
                    ->required()
                    ->disabled()
                    ->label(__('app.work_application')),
                Select::make('from_status')
                    ->options(ApplicationStatus::class)
                    ->default(null)
                    ->label(__('app.from_status'))
                    ->helperText(__('app.leave_empty_for_initial_status')),
                Select::make('to_status')
                    ->options(ApplicationStatus::class)
                    ->required()
                    ->label(__('app.to_status')),
                DateTimePicker::make('changed_at')
                    ->required()
                    ->default(now())
                    ->label(__('app.changed_at')),
            ]);
    }
}
