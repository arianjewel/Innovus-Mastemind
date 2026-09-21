<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Support\ImagePlaceholder;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Building Sustainable Infrastructure with Innovation & Excellence',
                'subtitle' => 'Leading construction, consultancy and supplier company in Bangladesh — delivering water management, structural design and development projects since 2021.',
                'cta_text' => 'Explore Our Services',
                'cta_link' => '/services',
                'file' => 'sliders/hero-construction.svg',
                'label' => 'Construction Excellence',
                'sub' => 'Innovus Mastermind',
                'palette' => ['#0f2436', '#0e7490'],
            ],
            [
                'title' => 'Urban Water Management & Engineering Consultancy',
                'subtitle' => 'Hydraulic modelling, water supply network design, stormwater drainage and feasibility studies for government organizations, NGOs and development partners.',
                'cta_text' => 'View Our Projects',
                'cta_link' => '/projects',
                'file' => 'sliders/hero-water.svg',
                'label' => 'Water Resources Engineering',
                'sub' => 'Hydraulic Modelling • GIS • Design',
                'palette' => ['#164e63', '#0891b2'],
            ],
            [
                'title' => 'Quality Construction Materials & Equipment Supply',
                'subtitle' => 'HDPE, PVC & GI pipes, water supply equipment, sanitary materials, safety equipment and engineering tools — delivered on time, every time.',
                'cta_text' => 'Browse Products',
                'cta_link' => '/products',
                'file' => 'sliders/hero-supply.svg',
                'label' => 'Suppliers & Logistics',
                'sub' => 'Pipes • Pumps • Safety Gear',
                'palette' => ['#155e75', '#06b6d4'],
            ],
        ];

        foreach ($slides as $i => $slide) {
            ImagePlaceholder::make($slide['file'], $slide['label'], $slide['sub'], $slide['palette']);

            Slider::create([
                'title' => $slide['title'],
                'subtitle' => $slide['subtitle'],
                'image_path' => $slide['file'],
                'cta_text' => $slide['cta_text'],
                'cta_link' => $slide['cta_link'],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }
}
