<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brochure;
use Illuminate\Support\Facades\Storage;

class EbrochureController extends Controller
{
    public function show(): \Inertia\Response
    {
        $brochure = Brochure::active()->first();

        return \Inertia\Inertia::render('Public/Ebrochure', [
            'brochure' => $brochure ? [
                'id' => $brochure->id,
                'title' => $brochure->title,
                'description' => $brochure->description,
                'url' => $brochure->url(),
                'sizeBytes' => (int) $brochure->size_bytes,
            ] : null,
        ]);
    }

    public function downloadLatest()
    {
        $brochure = Brochure::active()->first();
        abort_unless((bool) $brochure, 404);

        return $this->download($brochure);
    }

    public function download(Brochure $brochure)
    {
        abort_unless($brochure->is_active, 404);

        $brochure->increment('downloads');

        return Storage::disk('public')->download(
            $brochure->pdf_path,
            str($brochure->title)->slug()->append('.pdf')->toString()
        );
    }
}
