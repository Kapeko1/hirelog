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

                return new HtmlString('
                    <div x-data="{
                            width: 0,
                            percentage: '.$percentage.',
                            usedMB: '.$usedMB.',
                            maxMB: '.$maxMB.',
                            isDark: document.documentElement.classList.contains(\'dark\'),

                            getBarColor() {
                                if (this.percentage >= 90) return \'#ef4444\';
                                if (this.percentage >= 70) return \'#eab308\';
                                return \'#22c55e\';
                            },

                            updateFromDOM() {
                                const dataEl = this.$el.querySelector(\'[data-storage-info]\');
                                if (dataEl) {
                                    const newPercentage = parseFloat(dataEl.dataset.percentage);
                                    const newUsedMB = parseFloat(dataEl.dataset.usedmb);
                                    const newMaxMB = parseFloat(dataEl.dataset.maxmb);

                                    if (newPercentage !== this.percentage) {
                                        this.percentage = newPercentage;
                                        this.usedMB = newUsedMB;
                                        this.maxMB = newMaxMB;

                                        // Animate to new width
                                        this.width = 0;
                                        setTimeout(() => this.width = this.percentage, 50);
                                    }
                                }
                            },

                            init() {
                                setTimeout(() => this.width = this.percentage, 100);

                                // Dark mode observer
                                const darkObserver = new MutationObserver(() => {
                                    this.isDark = document.documentElement.classList.contains(\'dark\');
                                });
                                darkObserver.observe(document.documentElement, {
                                    attributes: true,
                                    attributeFilter: [\'class\']
                                });

                                // Storage data observer
                                const storageObserver = new MutationObserver(() => {
                                    this.updateFromDOM();
                                });

                                const dataEl = this.$el.querySelector(\'[data-storage-info]\');
                                if (dataEl) {
                                    storageObserver.observe(dataEl, {
                                        attributes: true,
                                        attributeFilter: [\'data-percentage\', \'data-usedmb\', \'data-maxmb\']
                                    });
                                }
                            }
                         }"
                         :style="{
                            background: isDark ? \'#1f2937\' : \'#ffffff\',
                            borderRadius: \'12px\',
                            padding: \'24px\',
                            marginBottom: \'16px\',
                            border: isDark ? \'1px solid #374151\' : \'1px solid #e5e7eb\',
                            boxShadow: \'0 1px 2px 0 rgba(0, 0, 0, 0.05)\'
                         }">

                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                            <div>
                                <h3 :style="{ fontSize: \'16px\', fontWeight: \'600\', margin: \'0\', color: isDark ? \'#ffffff\' : \'#171717\' }">
                                    '.__('app.used_space').'
                                </h3>
                                <p :style="{ margin: \'4px 0 0 0\', fontSize: \'14px\', color: isDark ? \'#9ca3af\' : \'#525252\' }">
                                    <span x-text="usedMB.toFixed(2)"></span> MB / <span x-text="maxMB"></span> MB
                                </p>
                            </div>
                            <div :style="{ fontSize: \'20px\', fontWeight: \'700\', color: isDark ? \'#9ca3af\' : \'#525252\' }">
                                <span x-text="width.toFixed(1) + \'%\'">'.$percentage.'%</span>
                            </div>
                        </div>

                        <div :style="{
                            position: \'relative\',
                            height: \'12px\',
                            width: \'100%\',
                            overflow: \'hidden\',
                            borderRadius: \'9999px\',
                            backgroundColor: isDark ? \'#374151\' : \'#e5e7eb\'
                         }">
                            <div :style="{
                                height: \'100%\',
                                borderRadius: \'9999px\',
                                transition: \'all 0.7s cubic-bezier(0.4, 0, 0.2, 1)\',
                                width: width + \'%\',
                                backgroundColor: getBarColor(),
                                minWidth: width > 0 ? \'4px\' : \'0\'
                            }">
                            </div>
                        </div>

                        <!-- Hidden element with data for observer -->
                        <div data-storage-info
                             data-percentage="'.$percentage.'"
                             data-usedmb="'.$usedMB.'"
                             data-maxmb="'.$maxMB.'"
                             style="display: none;"></div>
                    </div>
                ');
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
