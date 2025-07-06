<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
    ->middleware(['auth'])
    ->name('documents.download');
