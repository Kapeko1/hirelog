<?php

namespace App\Filament\Resources\WorkApplicationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Dokumenty';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('file_path')
                    ->label('Plik PDF')
                    ->nullable()
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('work-application-documents/' . date('Y/m'))
                    ->disk('local')
                    ->visibility('private')
                    ->maxSize(10240)
                    ->helperText('Maksymalny rozmiar wynosi 10Mb'),

                Forms\Components\TextInput::make('description')
                    ->label('Opis')
                    ->placeholder('Np. CV, List Motywacyjny, Portfolio')
                    ->nullable()
                    ->maxLength(255),

            ]);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Opis')
                    ->searchable()
                    ->placeholder('Brak opisu'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data dodania')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Dodaj nowy dokument'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Pobierz')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Document $document): string => route('documents.download', ['document' => $document->id]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
