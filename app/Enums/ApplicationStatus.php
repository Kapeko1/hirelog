<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ApplicationStatus: string implements HasLabel
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
}
