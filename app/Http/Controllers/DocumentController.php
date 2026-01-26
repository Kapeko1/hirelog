<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\WorkApplication;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    /**
     * @return StreamedResponse
     */
    public function download(Document $document)
    {
        if ($document->documentable_type !== WorkApplication::class ||
            $document->documentable->user_id !== auth()->id()) {
            abort(403, 'Brak dostępu do tego dokumentu.');
        }

        if (! Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'Plik nie znaleziony.');
        }

        return Storage::disk('local')->download($document->file_path, $document->file_name ?? basename($document->file_path));
    }
}
