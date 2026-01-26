<?php

namespace App\Filament\Resources;

use App\Enums\ApplicationStatus;
use App\Filament\Resources\WorkApplicationResource\Pages\CreateWorkApplication;
use App\Filament\Resources\WorkApplicationResource\Pages\EditWorkApplication;
use App\Filament\Resources\WorkApplicationResource\Pages\ListWorkApplications;
use App\Filament\Resources\WorkApplicationResource\RelationManagers\DocumentsRelationManager;
use App\Filament\Resources\WorkApplicationResource\RelationManagers\NotesRelationManager;
use App\Models\WorkApplication;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WorkApplicationResource extends Resource
{
    protected static ?string $model = WorkApplication::class;

    public static function getNavigationLabel(): string
    {
        return __('app.applications');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.applications');
    }

    public static function getModelLabel(): string
    {
        return __('app.applications');
    }

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('job_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('app.job_name')),

                TextInput::make('company_name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('app.company_name')),

                DateTimePicker::make('application_date')
                    ->required()
                    ->label(__('app.application_date'))
                    ->default(now()),

                Select::make('status')
                    ->options(ApplicationStatus::class)
                    ->required()
                    ->label(__('app.status'))
                    ->default(ApplicationStatus::Applied),

                TextArea::make('job_url')
                    ->nullable()
                    ->maxLength(255)
                    ->label(__('app.job_url')),

                TextInput::make('location')
                    ->label(__('app.location'))
                    ->nullable()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('job_name')
                    ->label(__('app.position'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('company_name')
                    ->label(__('app.company'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('application_date')
                    ->label(__('app.date_submitted'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label(__('app.status'))
                    ->badge()
                    ->color(fn (ApplicationStatus $state): string => match ($state) {
                        ApplicationStatus::Applied => 'gray',
                        ApplicationStatus::Verification => 'info',
                        ApplicationStatus::Interview => 'warning',
                        ApplicationStatus::Offer => 'success',
                        ApplicationStatus::Hired => 'success',
                        ApplicationStatus::Rejected => 'danger',
                        ApplicationStatus::Ghosted => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('location')
                    ->label(__('app.location'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('app.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            NotesRelationManager::class,
            DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkApplications::route('/'),
            'create' => CreateWorkApplication::route('/create'),
            'edit' => EditWorkApplication::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
