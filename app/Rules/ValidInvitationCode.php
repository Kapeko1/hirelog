<?php

namespace App\Rules;

use App\Models\InvitationCode;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidInvitationCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $code = InvitationCode::findByCode($value);
        
        if (!$code) {
            $fail('Podany kod zaproszenia nie istnieje.');
        } elseif (!$code->isAvailable()) {
            $fail('Ten kod zaproszenia został już wykorzystany.');
        }
    }
}
