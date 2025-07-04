<?php

namespace App\Filament\Resources\WorkApplicationResource\Pages;

use App\Filament\Resources\WorkApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Builder;


class ListWorkApplications extends ListRecords
{
    protected static string $resource = WorkApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Wszystkie'),
            'applied' => Tab::make('Złożono')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Applied)),
            'verification' => Tab::make('Weryfikacja')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Verification)),
            'interview' => Tab::make('Rozmowa')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Interview)),
            'offer' => Tab::make('Oferta')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Offer)),
            'positive' => Tab::make('Pozytywne')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Hired)),
            'negative' => Tab::make('Negatywne')
                ->modifyQueryUsing(fn (Builder $query) =>
                $query->whereIn('status', [
                    ApplicationStatus::Rejected,
                    ApplicationStatus::Ghosted
                ])),
        ];
    }
}
