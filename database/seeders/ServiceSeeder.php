<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Support\ImagePlaceholder;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Construction Services',
                'icon' => 'building',
                'short_desc' => 'Residential, commercial and industrial construction with full compliance to BNBC standards — from foundation to handover.',
                'description' => "We deliver end-to-end construction services covering residential and commercial buildings, industrial structures, water supply infrastructure and sanitation facilities. Our experienced site teams ensure quality workmanship, safety management and timely delivery on every contract.\n\nAll works are executed in adherence to Bangladesh National Building Code (BNBC) and client specifications, under continuous supervision of qualified civil engineers.",
                'features' => [
                    'Residential Building Construction',
                    'Commercial Building Construction',
                    'Industrial Structures',
                    'Internal Road Construction',
                    'Boundary Wall & Gate Construction',
                    'Pipe Network Installation',
                    'Water Supply Infrastructure',
                    'Drainage & Sewerage Systems',
                    'Sanitation Facilities (Toilet, Septic Tank Construction)',
                    'Renovation & Maintenance Works',
                ],
                'file' => 'services/construction.svg',
                'label' => 'Construction Services',
                'palette' => ['#0f2436', '#155e75'],
            ],
            [
                'title' => 'Engineering Consultancy',
                'icon' => 'drafting',
                'short_desc' => 'Structural design, feasibility studies, hydraulic modelling, GIS & remote sensing, urban planning and project supervision by BUET/DUET engineers.',
                'description' => "Our consultancy team provides complete engineering design and advisory services for infrastructure and water resource projects. We combine advanced modelling tools (WaterGEMS, SewerGEMS, MIKE URBAN, ETABS, Civil 3D) with deep field experience across Bangladesh.\n\nFrom concept to as-built documentation, we support government agencies, development partners and private clients with rigorous analysis and practical, buildable designs.",
                'features' => [
                    'Structural Design (RCC, Steel & Industrial Structures)',
                    'Project Planning & Feasibility Study',
                    'BOQ & Cost Estimation',
                    'Project Supervision & Management',
                    'Water Resource Management',
                    'Hydraulic Modelling',
                    'GIS & Remote Sensing Services',
                    'Urban & Regional Planning',
                    'Water Quality Testing Consultancy',
                    'Environmental & Infrastructure Planning',
                    'Preparation of As-Built Drawings',
                ],
                'file' => 'services/consultancy.svg',
                'label' => 'Engineering Consultancy',
                'palette' => ['#164e63', '#0891b2'],
            ],
            [
                'title' => 'Supply Services',
                'icon' => 'truck',
                'short_desc' => 'Construction materials, pipes, pumps, sanitary items, safety equipment and engineering tools sourced from trusted manufacturers.',
                'description' => "We supply quality construction materials and engineering equipment for projects of every scale. Our sourcing network covers leading local and international manufacturers, ensuring genuine products with proper certification.\n\nFrom HDPE/PVC/GI pipe systems to safety gear and survey instruments, we handle procurement, logistics and delivery so your project never waits on materials.",
                'features' => [
                    'Construction Materials Supply',
                    'Water Supply Equipment',
                    'HDPE, PVC & GI Pipe Supply',
                    'Sanitary Materials Supply',
                    'Mechanical & Electrical Items',
                    'Safety Equipment',
                    'Engineering Tools & Accessories',
                ],
                'file' => 'services/supply.svg',
                'label' => 'Supply Services',
                'palette' => ['#0e7490', '#22d3ee'],
            ],
            [
                'title' => 'Software Development & IT Solutions',
                'icon' => 'code',
                'short_desc' => 'Custom web & mobile application development, UI/UX design, cloud deployment and managed IT services by a skilled engineering team.',
                'description' => "We help organizations digitize and scale with end-to-end software development services — from requirement analysis and architecture design to development, testing, deployment and long-term maintenance.\n\nOur engineers build secure, maintainable and performance-optimized applications for web, mobile and desktop using modern frameworks and DevOps best practices. We also provide UI/UX design, API integration, database design and cloud infrastructure management to cover the entire product lifecycle.",
                'features' => [
                    'Custom Web Application Development',
                    'Mobile Application Development (Android & iOS)',
                    'UI/UX Design & Prototyping',
                    'E-Commerce & Marketplace Solutions',
                    'ERP, CRM & Business Management Systems',
                    'API Design, Integration & Third-Party Services',
                    'Database Design & Optimization',
                    'Cloud Services & DevOps (AWS, Azure, GCP)',
                    'Website Development & Maintenance',
                    'Cybersecurity & Data Protection',
                    'IT Consultation & Managed IT Support',
                ],
                'file' => 'services/software.svg',
                'label' => 'Software Development',
                'palette' => ['#312e81', '#4f46e5'],
            ],
        ];

        foreach ($services as $i => $service) {
            ImagePlaceholder::make($service['file'], $service['label'], 'Innovus Mastermind', $service['palette']);

            Service::create([
                'title' => $service['title'],
                'icon' => $service['icon'],
                'short_desc' => $service['short_desc'],
                'description' => $service['description'],
                'features' => $service['features'],
                'image_path' => $service['file'],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }
}
