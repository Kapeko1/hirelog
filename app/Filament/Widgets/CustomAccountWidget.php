<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CustomAccountWidget extends Widget
{
    protected static ?int $sort = -3;

    protected int|string|array $columnSpan = 'full';

    protected static bool $isLazy = false;

    protected string $view = 'filament-panels::widgets.account-widget';
}
