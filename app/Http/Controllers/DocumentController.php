<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Document $document)
    {
        if ($document->documentable_type !== \App\Models\WorkApplication::class ||
            $document->documentable->user_id !== auth()->id()) {
            abort(403, 'Brak dostępu do tego dokumentu.');
        }

        if (! Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'Plik nie znaleziony.');
        }

        return Storage::disk('local')->download($document->file_path, $document->file_name ?? basename($document->file_path));
    }
}
