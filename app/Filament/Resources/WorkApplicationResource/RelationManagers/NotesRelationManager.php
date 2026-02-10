<?php

namespace App\Filament\Resources\WorkApplicationResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('app.notes');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                RichEditor::make('content')
                    ->label(__('app.note_content'))
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(60000)
                    ->helperText(__('app.max_characters')),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(__('app.note_record'))
            ->columns([
                TextColumn::make('content')
                    ->label(__('app.content'))
                    ->limit(150)
                    ->searchable()
                    ->placeholder(__('app.no_content'))
                    ->html(),

                TextColumn::make('created_at')
                    ->label(__('app.date_added'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('app.date_modified'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->modalHeading(),
                ]),
            ]);
    }
}
