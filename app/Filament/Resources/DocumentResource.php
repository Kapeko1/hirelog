<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages\ListDocuments;
use App\Models\Document;
use App\Models\WorkApplication;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?int $navigationSort = 2;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationLabel(): string
    {
        return __('app.documents');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.documents');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->header(function () {
                $documents = Document::whereHas('documentable', function ($query) {
                    $query->where('user_id', auth()->id());
                })->get();

                $totalSize = 0;
                foreach ($documents as $document) {
                    if ($document->file_path && file_exists(storage_path('app/private/'.$document->file_path))) {
                        $totalSize += filesize(storage_path('app/private/'.$document->file_path));
                    }
                }

                $usedMB = round($totalSize / 1024 / 1024, 2);
                $maxMB = 15;
                $percentage = round(($totalSize / (15 * 1024 * 1024)) * 100, 1);

                return new HtmlString(
                    '<div class="p-4 bg-gray-400 rounded-lg mb-4">
                        <p class="text-sm text-gray-700">
                            <strong>'.__('app.used_space').'</strong> '.$usedMB.' MB / '.$maxMB.' MB ('.$percentage.'%)
                        </p>
                    </div>'
                );
            })
            ->columns([
                TextColumn::make('description')
                    ->label(__('app.description'))
                    ->searchable()
                    ->placeholder(__('app.no_description')),
                TextColumn::make('created_at')
                    ->label(__('app.date_added'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
                TextColumn::make('documentable.company_name')
                    ->label(__('app.company'))
                    ->searchable()
                    ->placeholder(__('app.no_company')),
                TextColumn::make('file_size')
                    ->label(__('app.size'))
                    ->getStateUsing(function ($record) {
                        if ($record->file_path && file_exists(storage_path('app/private/'.
                                $record->file_path))) {
                            return number_format(filesize(storage_path('app/private/'.
                                        $record->file_path)) / 1024 / 1024, 2).' MB';
                        }

                        return __('app.unknown_size');
                    })
                    ->sortable(false),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make(),
                Action::make('download')
                    ->label(__('app.download'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Document $record): string => route('documents.download', ['document' => $record->getKey()]))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([]);
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
            'index' => ListDocuments::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('documentable', function ($query) {
            $query->where('user_id', auth()->id());
        })->where('documentable_type', WorkApplication::class);
    }
}
