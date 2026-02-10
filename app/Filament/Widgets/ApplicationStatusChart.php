<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStatus;
use App\Models\WorkApplication;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ApplicationStatusChart extends ChartWidget
{
    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('app.applications_by_status');
    }

    protected ?string $maxHeight = '300px';

    protected int|string|array $columnSpan = 1;

    public static function canView(): bool
    {
        return WorkApplication::where('user_id', auth()->id())->exists();
    }

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
            $colors[] = $statusEnum->getHexColor();
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

    protected ?array $options = [
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
