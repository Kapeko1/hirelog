<?php

namespace App\Rules;

use App\Models\Document;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Translation\PotentiallyTranslatedString;

class UserStorageQuotaRule implements ValidationRule
{
    public int $maxQuotaBytes;

    public function __construct(int $maxQuotaMB = 15)
    {
        $this->maxQuotaBytes = $maxQuotaMB * 1024 * 1024;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=):PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value) {
            return;
        }

        $user = auth()->user();
        if (! $user) {
            return;
        }

        $currentUsage = Document::whereHas('documentable', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get()->sum(function ($document) {
            return Storage::disk('local')->exists($document->file_path)
                ? Storage::disk('local')->size($document->file_path)
                : 0;
        });

        $newFileSize = $value->getSize();

        if (($currentUsage + $newFileSize) > $this->maxQuotaBytes) {
            $remaining = max(0, $this->maxQuotaBytes - $currentUsage);
            $remainingMB = round($remaining / 1024 / 1024, 2);
            $fail("Przekroczono limit miejsca (15MB). Pozostało: {$remainingMB}MB");
        }
    }
}
