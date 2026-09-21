<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProjectDocument;
use Illuminate\Support\Facades\Storage;

class ProjectDocumentController extends Controller
{
    public function download(ProjectDocument $document)
    {
        abort_unless($document->project()->where('is_active', true)->exists(), 404);

        $filename = str($document->title)->slug()->append('.pdf')->toString();

        return Storage::disk('public')->download($document->file_path, $filename);
    }
}
