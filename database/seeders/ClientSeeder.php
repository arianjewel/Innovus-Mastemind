<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Support\ImagePlaceholder;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            'Department of Public Health Engineering (DPHE)',
            'IDE-Tetra Private Limited',
            'Eco-Social Development Organization (ESDO)',
            'Solid Construction',
            'Monir Engineering and Construction Ltd.',
            'A. T. Bhuiyan Builders Ltd.',
            'Shamim Traders',
        ];

        foreach ($clients as $i => $name) {
            $file = 'clients/'.str($name)->slug().'.svg';
            ImagePlaceholder::make($file, $name, 'Key Client', ['#e2e8f0', '#cbd5e1']);

            // light background palette needs dark text — regenerate with dark label handled by SVG fill; acceptable
            Client::create([
                'name' => $name,
                'logo_path' => $file,
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }
}
