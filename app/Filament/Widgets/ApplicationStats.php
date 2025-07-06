<?php

namespace App\Filament\Widgets;

use App\Models\WorkApplication;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationStats extends BaseWidget
{
    protected int|string|array $columnSpan = 2;

    protected function getStats(): array
    {
        $userId = auth()->id();
        $now = Carbon::now();

        $totalApplications = WorkApplication::where('user_id', $userId)->count();
        $totalApplicationsToday = WorkApplication::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $startOfLast7Days = $now->copy()->subDays(6)->startOfDay();
        $endOfLast7Days = $now->copy();
        $totalApplicationsLast7Days = WorkApplication::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfLast7Days, $endOfLast7Days])
            ->count();

        return [
            Stat::make(__('app.total_applications'), $totalApplications)
                ->icon('heroicon-o-briefcase'),

            Stat::make(__('app.today'), $totalApplicationsToday)
                ->icon('heroicon-o-calendar-days'),

            Stat::make(__('app.last_7_days'), $totalApplicationsLast7Days)
                ->icon('heroicon-o-arrow-path'),

        ];

    }

    public static function canView(): bool
    {
        return WorkApplication::where('user_id', auth()->id())->exists();
    }
}
