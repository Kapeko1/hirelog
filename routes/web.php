<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LocaleController;
use App\Livewire\Index;
use Illuminate\Support\Facades\Route;

Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
    ->middleware(['auth'])
    ->name('documents.download');

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])
    ->middleware(['throttle:10,1']) // Rate limit: 10 requests per minute
    ->name('locale.switch');

Route::get('/', Index::class)
    ->middleware(['throttle:60,1']) // Rate limit: 60 requests per minute
    ->name('landing');
