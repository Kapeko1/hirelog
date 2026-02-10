<?php

namespace App\Filament\Resources\WorkApplicationResource\RelationManagers;

use App\Models\Document;
use App\Rules\UserStorageQuotaRule;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
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

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('file_path')
                    ->label(__('app.pdf_file'))
                    ->acceptedFileTypes(config('documents.accepted_file_types'))
                    ->directory(config('documents.directory').'/'.date('Y/m'))
                    ->disk(config('documents.disk'))
                    ->visibility(config('documents.visibility'))
                    ->maxSize(config('documents.max_file_size'))
                    ->helperText(__('app.max_file_size'))
                    ->storeFileNamesIn('file_name')
                    ->rules([
                        new UserStorageQuotaRule,
                        'max:'.config('documents.max_file_size'),
                    ])
                    ->validationMessages([
                        'max' => __('app.file_too_large'),
                        'required' => __('validation.required', ['attribute' => __('app.pdf_file')]),
                    ])
                    ->required(),

                TextInput::make('description')
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
                TextColumn::make('description')
                    ->label(__('app.description'))
                    ->searchable()
                    ->placeholder(__('app.no_description')),

                TextColumn::make('created_at')
                    ->label(__('app.date_added'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('app.add_new_document')),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->modalHeading(__('app.confirm_bulk_delete'))
                    ->modalDescription(''),
                Action::make('download')
                    ->label(__('app.download'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Document $document): string => route('documents.download', ['document' => $document->id]))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->modalHeading(__('app.confirm_bulk_delete'))
                        ->modalDescription(''),
                ]),
            ]);
    }
}
