<?php

namespace Database\Seeders;

use App\Models\Brochure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BrochureSeeder extends Seeder
{
    public function run(): void
    {
        $source = storage_path('app/_seed/company-profile.pdf');

        $path = 'brochures/company-profile-innovus-mastermind.pdf';

        if (is_file($source)) {
            Storage::disk('public')->put($path, file_get_contents($source));
            $size = filesize($source);
        } else {
            // fallback minimal placeholder pdf so the page never breaks
            $placeholder = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 612 792]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n4 0 obj<</Length 90>>stream\nBT /F1 22 Tf 72 700 Td (Innovus Mastermind - Company Profile) Tj ET\nendstream endobj\n5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\ntrailer<</Root 1 0 R>>\n%%EOF";
            Storage::disk('public')->put($path, $placeholder);
            $size = strlen($placeholder);
        }

        Brochure::query()->updateOrCreate(
            ['title' => 'Company Profile — Innovus Mastermind'],
            [
                'description' => 'Complete company profile: services, leadership, consultant panel, project experience, equipment and company information.',
                'pdf_path' => $path,
                'size_bytes' => $size,
                'is_active' => true,
            ]
        );
    }
}
