<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ApplicationStatus: string implements HasLabel, HasColor
{
    case Applied = 'Applied';
    case Verification = 'Verification';
    case Interview = 'Interview';
    case Offer = 'Offer';
    case Rejected = 'Rejected';
    case Hired = 'Hired';
    case Ghosted = 'Ghosted';

    public function getLabel(): string
    {
        return match ($this) {
            self::Applied => __('statuses.applied'),
            self::Verification => __('statuses.verification'),
            self::Interview => __('statuses.interview'),
            self::Offer => __('statuses.offer'),
            self::Rejected => __('statuses.rejected'),
            self::Hired => __('statuses.hired'),
            self::Ghosted => __('statuses.ghosted'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Applied => 'info',
            self::Verification => 'cyan',
            self::Interview => 'warning',
            self::Offer => 'lime',
            self::Hired => 'green',
            self::Rejected => 'rose',
            self::Ghosted => 'stone',
        };
    }
}
