<?php

namespace App\Filament\Resources\WorkApplicationResource\RelationManagers;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make('content')
                    ->label(__('app.content'))
                    ->limit(150)
                    ->searchable()
                    ->placeholder(__('app.no_content'))
                    ->html(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('app.date_added'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('app.date_modified'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
