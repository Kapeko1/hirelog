<?php

namespace App\Filament\Resources\WorkApplicationResource\Pages;

use App\Enums\ApplicationStatus;
use App\Filament\Resources\WorkApplicationResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
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
            'all' => Tab::make(__('app.all')),
            'applied' => Tab::make(__('app.applied'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Applied)),
            'verification' => Tab::make(__('app.verification'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Verification)),
            'interview' => Tab::make(__('app.interview'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Interview)),
            'offer' => Tab::make(__('app.offer'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Offer)),
            'positive' => Tab::make(__('app.hired'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status',
                    ApplicationStatus::Hired)),
            'negative' => Tab::make(__('app.ghosted_rejected'))
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', [
                    ApplicationStatus::Rejected,
                    ApplicationStatus::Ghosted,
                ])),
        ];
    }
}
