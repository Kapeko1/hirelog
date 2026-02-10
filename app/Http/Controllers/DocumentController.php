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
        // Security check: verify document type
        if ($document->documentable_type !== WorkApplication::class) {
            abort(403, __('app.document_access_denied'));
        }

        // Security check: verify documentable exists
        if (! $document->documentable) {
            abort(404, __('app.document_not_available'));
        }

        // Security check: verify document belongs to authenticated user
        if ($document->documentable->user_id !== auth()->id()) {
            abort(403, __('app.document_access_denied'));
        }

        $disk = Storage::disk(config('documents.disk'));

        if (! $disk->exists($document->file_path)) {
            abort(404, __('app.file_not_found'));
        }

        return $disk->download($document->file_path, $document->file_name ?? basename($document->file_path));
    }
}
