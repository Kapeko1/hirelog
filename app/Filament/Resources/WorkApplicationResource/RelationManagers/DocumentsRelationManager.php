<?php

namespace App\Filament\Resources\WorkApplicationResource\RelationManagers;

use App\Models\Document;
use App\Rules\UserStorageQuotaRule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('app.documents');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('file_path')
                    ->label(__('app.pdf_file'))
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('work-application-documents/'.date('Y/m'))
                    ->disk('local')
                    ->visibility('private')
                    ->maxSize(2048)
                    ->helperText(__('app.max_file_size'))
                    ->storeFileNamesIn('file_name')
                    ->rules([new UserStorageQuotaRule])
                    ->required(),

                Forms\Components\TextInput::make('description')
                    ->label(__('app.description'))
                    ->placeholder(__('app.description_placeholder'))
                    ->nullable()
                    ->maxLength(255),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label(__('app.description'))
                    ->searchable()
                    ->placeholder(__('app.no_description')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('app.date_added'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('app.add_new_document')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download')
                    ->label(__('app.download'))
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
