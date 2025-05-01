<?php

namespace App\Filament\Resources;

use App\Enums\ApplicationStatus;
use App\Filament\Resources\WorkApplicationResource\Pages;
use App\Filament\Resources\WorkApplicationResource\RelationManagers;
use App\Models\WorkApplication;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkApplicationResource extends Resource
{
    protected static ?string $model = WorkApplication::class;

    public static function getNavigationLabel(): string
    {
        return __('Aplikacje');
    }
    public static function getPluralModelLabel(): string
    {
        return __('Aplikacje');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('job_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nazwa stanowiska'),

                TextInput::make('company_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nazwa firmy'),

                DateTimePicker::make('application_date')
                    ->required()
                    ->label('Data złożenia aplikacji')
                    ->default(now()),

                Select::make('status')
                    ->options(ApplicationStatus::class)
                    ->required()
                    ->label('Status')
                    ->default(ApplicationStatus::Applied),

                TextArea::make('job_url')
                    ->nullable()
                    ->maxLength(255)
                    ->label('Link do ogłoszenia'),

                Forms\Components\TextInput::make('location')
                    ->label('Lokalizacja')
                    ->nullable()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('job_name')
                    ->label('Stanowisko')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Firma')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('application_date')
                    ->label('Data złożenia')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ApplicationStatus $state):string =>match ($state) {
                        ApplicationStatus::Applied => 'gray',
                        ApplicationStatus::Verification => 'info',
                        ApplicationStatus::Interview => 'warning',
                        ApplicationStatus::Offer => 'success',
                        ApplicationStatus::Hired => 'success',
                        ApplicationStatus::Rejected => 'danger',
                        ApplicationStatus::Ghosted => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokalizacja')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dodano')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\NotesRelationManager::class,
            RelationManagers\DocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkApplications::route('/'),
            'create' => Pages\CreateWorkApplication::route('/create'),
            'edit' => Pages\EditWorkApplication::route('/{record}/edit'),
        ];
    }

}
