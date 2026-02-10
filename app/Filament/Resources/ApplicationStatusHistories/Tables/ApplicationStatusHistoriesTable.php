<?php

namespace App\Filament\Resources\ApplicationStatusHistories\Tables;

use App\Enums\ApplicationStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ApplicationStatusHistoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->whereHas('workApplication', fn($q) => $q->where('user_id', auth()->id())))
            ->columns([
                TextColumn::make('workApplication.company_name')
                    ->searchable()
                    ->sortable()
                    ->label(__('app.company_name')),
                TextColumn::make('workApplication.position')
                    ->searchable()
                    ->sortable()
                    ->label(__('app.position')),
                TextColumn::make('from_status')
                    ->badge()
                    ->color(fn($state) => $state?->getColor())
                    ->formatStateUsing(fn($state) => $state?->getLabel() ?? __('app.initial'))
                    ->label(__('app.from_status')),
                TextColumn::make('to_status')
                    ->badge()
                    ->color(fn($state) => $state->getColor())
                    ->label(__('app.to_status')),
                TextColumn::make('changed_at')
                    ->dateTime()
                    ->sortable()
                    ->label(__('app.changed_at'))
                    ->default(now()),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('app.created_at')),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('app.updated_at')),
            ])
            ->filters([
                SelectFilter::make('work_application_id')
                    ->relationship('workApplication', 'company_name', fn($query) => $query->where('user_id', auth()->id()))
                    ->searchable()
                    ->preload()
                    ->label(__('app.work_application')),
                SelectFilter::make('from_status')
                    ->options(ApplicationStatus::class)
                    ->label(__('app.from_status')),
                SelectFilter::make('to_status')
                    ->options(ApplicationStatus::class)
                    ->label(__('app.to_status')),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('changed_at', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
