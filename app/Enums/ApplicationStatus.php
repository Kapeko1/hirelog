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

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Applied => 'Złożono',
            self::Verification => 'Weryfikacja',
            self::Interview => 'Rozmowa kwalifikacyjna',
            self::Offer => 'Oferta',
            self::Rejected => 'Odrzucono',
            self::Hired => 'Zatrudniono',
            self::Ghosted => 'Ghosting :(',
        };
    }
}
