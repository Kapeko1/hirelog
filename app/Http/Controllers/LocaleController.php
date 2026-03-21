<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class LocaleController extends Controller
{
    public function switch(Request $request, $locale)
    {
        // Whitelist validation - prevent locale injection
        if (!in_array($locale, ['pl', 'en'], true)) {
            abort(400, 'Invalid locale');
        }

        // Store locale in session
        Session::put('locale', $locale);
        app()->setLocale($locale);

        // Prevent open redirect vulnerability
        $referer = $request->header('referer');

        if ($referer && $this->isValidReferer($referer)) {
            return redirect($referer);
        }

        // Fallback to home page if referer is not valid
        return redirect()->route('landing');
    }

    /**
     * Validate referer to prevent open redirect attacks
     */
    private function isValidReferer(string $referer): bool
    {
        $appUrl = parse_url(config('app.url'));
        $refererUrl = parse_url($referer);

        // Check if referer is from the same domain
        if (!isset($refererUrl['host']) || !isset($appUrl['host'])) {
            return false;
        }

        return $refererUrl['host'] === $appUrl['host'];
    }
}
