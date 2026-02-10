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

    public function __construct(?int $maxQuotaMB = null)
    {
        $maxQuotaMB = $maxQuotaMB ?? config('documents.user_quota_mb', 100);
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

        $disk = Storage::disk(config('documents.disk'));

        $currentUsage = Document::whereHas('documentable', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get()->sum(function ($document) use ($disk) {
            return $disk->exists($document->file_path)
                ? $disk->size($document->file_path)
                : 0;
        });

        $newFileSize = $value->getSize();

        if (($currentUsage + $newFileSize) > $this->maxQuotaBytes) {
            $remaining = max(0, $this->maxQuotaBytes - $currentUsage);
            $remainingMB = round($remaining / 1024 / 1024, 2);
            $maxQuotaMB = round($this->maxQuotaBytes / 1024 / 1024);
            $fail("Przekroczono limit miejsca ({$maxQuotaMB}MB). Pozostało: {$remainingMB}MB");
        }
    }
}
