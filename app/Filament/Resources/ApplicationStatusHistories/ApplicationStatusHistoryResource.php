<?php

namespace App\Filament\Resources\ApplicationStatusHistories;

use App\Filament\Resources\ApplicationStatusHistories\Pages\CreateApplicationStatusHistory;
use App\Filament\Resources\ApplicationStatusHistories\Pages\EditApplicationStatusHistory;
use App\Filament\Resources\ApplicationStatusHistories\Pages\ListApplicationStatusHistories;
use App\Filament\Resources\ApplicationStatusHistories\Schemas\ApplicationStatusHistoryForm;
use App\Filament\Resources\ApplicationStatusHistories\Tables\ApplicationStatusHistoriesTable;
use App\Models\ApplicationStatusHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApplicationStatusHistoryResource extends Resource
{
    protected static ?string $model = ApplicationStatusHistory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('app.applications');
    }

    public static function getNavigationLabel(): string
    {
        return __('app.status_history');
    }

    public static function getModelLabel(): string
    {
        return __('app.status_history');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.status_history');
    }

    public static function form(Schema $schema): Schema
    {
        return ApplicationStatusHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationStatusHistoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplicationStatusHistories::route('/'),
            'create' => CreateApplicationStatusHistory::route('/create'),
            'edit' => EditApplicationStatusHistory::route('/{record}/edit'),
        ];
    }
}
