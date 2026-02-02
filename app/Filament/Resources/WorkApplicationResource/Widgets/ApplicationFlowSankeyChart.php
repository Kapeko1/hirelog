<?php

namespace App\Filament\Resources\WorkApplicationResource\Widgets;

use App\Models\ApplicationStatusHistory;
use Elemind\FilamentECharts\Widgets\EChartWidget;
use Illuminate\Support\Facades\DB;

class ApplicationFlowSankeyChart extends EChartWidget
{
    protected int|string|array $columnSpan = 'full';

    public function getHeading(): string
    {
        return __('app.application_status_flow');
    }

    protected static ?int $sort = 2;

    public ?string $theme = null;

    protected function getOptions(): array
    {
        $userId = auth()->id();

        // Get all status transitions from history
        $transitions = ApplicationStatusHistory::query()
            ->whereHas('workApplication', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->whereNotNull('from_status')
            ->whereNotNull('to_status')
            ->select('from_status', 'to_status', DB::raw('count(*) as count'))
            ->groupBy('from_status', 'to_status')
            ->get();

        $nodes = [];
        $links = [];
        $nodeSet = [];

        // Build nodes and links for Sankey diagram
        foreach ($transitions as $transition) {
            $fromStatus = $transition->from_status->value;
            $toStatus = $transition->to_status->value;
            $fromLabel = $transition->from_status->getLabel();
            $toLabel = $transition->to_status->getLabel();

            // Add nodes to set if not already present
            if (!isset($nodeSet[$fromStatus])) {
                $nodeSet[$fromStatus] = true;
                $nodes[] = [
                    'name' => $fromLabel,
                ];
            }

            if (!isset($nodeSet[$toStatus])) {
                $nodeSet[$toStatus] = true;
                $nodes[] = [
                    'name' => $toLabel,
                ];
            }

            // Add link
            $links[] = [
                'source' => $fromLabel,
                'target' => $toLabel,
                'value' => $transition->count,
            ];
        }

        return [
            'tooltip' => [
                'trigger' => 'item',
                'triggerOn' => 'mousemove',
            ],
            'series' => [
                [
                    'type' => 'sankey',
                    'data' => $nodes,
                    'links' => $links,
                    'emphasis' => [
                        'focus' => 'adjacency',
                    ],
                    'lineStyle' => [
                        'color' => 'gradient',
                        'curveness' => 0.5,
                    ],
                    'label' => [
                        'fontFamily' => 'Inter',
                        'fontSize' => 16,
                        'fontWeight' => 'bold',
                        'color' => '#fff',
                        'textBorderColor' => '#000',
                        'textBorderWidth' => 2,
                    ],
                ],
            ],
        ];
    }
}
