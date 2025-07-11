<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStatus;
use App\Models\WorkApplication;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ApplicationStatusChart extends ChartWidget
{
    protected static ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.applications_by_status');
    }

    protected static ?string $maxHeight = '300px';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $userId = auth()->id();
        $statusesData = WorkApplication::query()
            ->where('user_id', $userId)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();
        $labels = [];
        $data = [];
        $colors = [];

        foreach ($statusesData as $item) {
            $statusEnum = $item->status;

            $labels[] = $statusEnum->getLabel();

            $colors[] = match ($statusEnum) {
                ApplicationStatus::Applied => '#9CA3AF',
                ApplicationStatus::Verification => '#60A5FA',
                ApplicationStatus::Interview => '#FBBF24',
                ApplicationStatus::Offer => '#34D399',
                ApplicationStatus::Hired => '#10B981',
                ApplicationStatus::Rejected => '#F87171',
                ApplicationStatus::Ghosted => '#6B7280',
            };

            $data[] = $item->getAttribute('count');
        }

        return [
            'datasets' => [
                [
                    'label' => __('app.applications'),
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected static ?array $options = [
        'scales' => [
            'x' => [
                'display' => false,
            ],
            'y' => [
                'display' => false,
            ],
        ],
    ];
}
