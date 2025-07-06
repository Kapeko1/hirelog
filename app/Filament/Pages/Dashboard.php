<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ApplicationStats;
use App\Filament\Widgets\ApplicationStatusChart;
use App\Filament\Widgets\CustomAccountWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            ApplicationStatusChart::class,
            ApplicationStats::class,
            CustomAccountWidget::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }
}
