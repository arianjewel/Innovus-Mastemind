<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectDocument;
use App\Support\ImagePlaceholder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            // ---------------- Consultancy ----------------
            [
                'title' => 'Community Consultation, Mathematical Modelling & Detailed Design of Distribution Network for 29 Mini Water Supply Systems',
                'type' => 'consultancy',
                'client' => 'DevConsultants Ltd. – Department of Public Health Engineering (DPHE)',
                'location' => 'Sylhet, Netrokona, Moulovibazar, Habiganj, Sunamganj',
                'period' => '2026 – Ongoing',
                'contract_amount' => null,
                'status' => 'ongoing',
                'is_featured' => true,
                'overview' => "Engaged as technical consultants to deliver planning and design services for 29 mini water supply systems, supporting improved access to safe drinking water across rural and peri-urban communities under the \"Flood Reconstruction Emergency Assistance Project for Water Supply and Sanitation (GoB-ADB)\".",
                'scope' => [
                    'Conducting community consultation and social surveys to ensure participatory and needs-based design',
                    'Executing topographic surveys to inform accurate system planning and alignment',
                    'Developing hydraulic models using WaterGEMS software for mathematical simulation and network optimization',
                    'Preparing detailed engineering designs, reports and drawings for pipeline distribution networks',
                ],
            ],
            [
                'title' => 'Surveying, Mathematical Modelling & Detailed Design of Distribution Network under Host and Rohingya Enhancement of Live (HELP) Project',
                'slug' => 'surveying-mathematical-modelling-detailed-design-help-rohingya-project',
                'type' => 'consultancy',
                'client' => 'S R Enterprise – Department of Public Health Engineering (DPHE)',
                'location' => "Camp 02E, Camp 04, Camp 04 Ext., Camp 20 Ext., Cox's Bazar",
                'period' => '2026 – Ongoing',
                'contract_amount' => null,
                'status' => 'ongoing',
                'is_featured' => true,
                'overview' => "Engaged as technical consultants to deliver planning and design services for mini water supply systems, supporting improved access to safe drinking water for the displaced Myanmar nationals (Rohingya) and host communities under the \"Host and Rohingya Enhancement of Live Project (HELP)\".\n\nDeliverables include detailed distribution network layout drawings per camp block: overhead tank locations, tap stand positions, transmission junctions, pipe diameter classifications (50mm–110mm sub-mains), gate valves and fire hydrant placements with ground elevation profiles — prepared in CAD from topographic survey and WaterGEMS hydraulic modelling.",
                'scope' => [
                    'Conducting community consultation and social surveys to ensure participatory and needs-based design',
                    'Executing topographic surveys to support precise system planning and pipeline alignment',
                    'Developing hydraulic models using WaterGEMS software for mathematical simulation and network optimization',
                    'Preparing detailed engineering designs and drawings for pipeline distribution networks',
                    'Camp-block-wise distribution network layout drawings including overhead tanks, tap stands and valve arrangements',
                ],
                'documents' => [
                    ['file' => storage_path('app/_seed/camp-04-03.pdf'), 'title' => 'Camp 04 Block-03 — Distribution Network Layout Drawings'],
                    ['file' => storage_path('app/_seed/camp-04-05.pdf'), 'title' => 'Camp 04 Block-05 — Distribution Network Layout Drawings'],
                    ['file' => storage_path('app/_seed/camp-20x-04.pdf'), 'title' => 'Camp 20 Ext Block-04 — Distribution Network Layout Drawings'],
                ],
            ],
            [
                'title' => 'Community-Based Piped Water Supply Network Design & As-Built Drawing Preparation (1,400+ Schemes)',
                'type' => 'consultancy',
                'client' => 'SR Enterprise, Monir Engineering and Construction Ltd., A. T. Bhuiyan Builders Ltd., Shamim Traders',
                'location' => 'Chattogram, Noakhali, Kurigram, Gaibandha, Lalmonirhat, Habiganj, Brahmanbaria, Sherpur, Jamalpur, Lakshmipur',
                'period' => '2022 – Ongoing',
                'status' => 'ongoing',
                'is_featured' => true,
                'overview' => "Engaged as technical consultants to deliver planning and design services for mini water supply systems supporting safe drinking water access in rural areas for more than 1,400 schemes under the \"Rural Water, Sanitation and Hygiene for Human Capital Development (RWSHHCD) Project (GoB-World Bank)\".",
                'scope' => [
                    'Conducting household-level surveys using mobile-based KoboToolbox platforms for accurate, needs-based system design',
                    'Performing topographic surveys to support precise system planning and pipeline alignment',
                    'Undertaking GIS-based layout planning and water demand assessments for individual scheme design',
                    'Producing GIS-based as-built drawings and shapefiles for post-construction documentation and asset management',
                ],
            ],
            [
                'title' => 'Residential-cum-Commercial Building Design & Construction Supervision (8-Storied)',
                'type' => 'consultancy',
                'client' => 'Private Client',
                'location' => 'Pabna Sadar, Pabna',
                'period' => '2025 – Ongoing',
                'status' => 'ongoing',
                'overview' => "Engaged to provide full-scope structural and architectural design services along with construction supervision for a mixed-use high-rise development of an 8-storied building. The project reflects the firm's capability in delivering integrated design and oversight solutions.",
                'scope' => [
                    'Preparation of detailed architectural and structural designs for an 8-story residential-cum-commercial building',
                    'Ensuring compliance with applicable building codes, safety standards, and local regulations',
                    'Providing on-site construction supervision to ensure quality, design conformity, and structural integrity throughout all phases of construction',
                ],
            ],
            [
                'title' => 'Residential Building Design & Construction Supervision (9-Storied)',
                'type' => 'consultancy',
                'client' => 'Private Client',
                'location' => 'Dewanpara, Dhaka',
                'period' => '2022 – 2024',
                'status' => 'completed',
                'overview' => "Engaged to provide full-scope structural and architectural design services along with construction supervision for a residential 9-storied building.",
                'scope' => [
                    'Preparation of detailed architectural and structural designs for a 9-story residential building',
                    'Ensuring compliance with applicable building codes, safety standards, and local regulations',
                    'Providing on-site construction supervision throughout all phases of construction',
                ],
            ],
            [
                'title' => 'Structural Design of 15 Seven-Story Residential Buildings',
                'type' => 'consultancy',
                'client' => 'Solid Construction',
                'location' => 'Bashundhara Residential Area, Dhaka',
                'period' => '2023 – Ongoing',
                'status' => 'ongoing',
                'overview' => "Engaged to provide structural planning and design services for a large-scale residential development comprising 15 seven-story buildings, demonstrating the firm's capacity to deliver consistent, high-quality structural engineering solutions across multiple simultaneous building units.",
                'scope' => [
                    'Structural planning and detailed engineering design for 15 individual seven-story residential buildings',
                    'Ensuring structural safety, load analysis, and compliance with relevant building codes and standards',
                    'Preparation of construction drawings and design documentation to support seamless project execution',
                ],
            ],
            [
                'title' => 'Water Quality Testing in Government Primary Schools of Dhaka District (PEDP4)',
                'type' => 'consultancy',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'Dhaka District',
                'period' => '2025',
                'status' => 'completed',
                'overview' => 'Water quality testing and certification services for government primary schools at Dhaka district under PEDP4 project.',
                'scope' => [
                    'Water quality testing and certification services',
                ],
            ],

            // ---------------- Construction ----------------
            [
                'title' => 'Construction of 4 RCC WASH Blocks at Government Primary Schools (2-Storied)',
                'type' => 'construction',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'Dhaka Division',
                'period' => '2026',
                'contract_amount' => 5394431,
                'status' => 'completed',
                'packages' => 'GPS/WB-1497, GPS/WB-1294/2, GPS/WB-1294/4, GPS/WB-1294/5',
                'is_featured' => true,
                'overview' => "Engaged to supply, construct, and commission four 2-storied RCC WASH blocks with 2-storied foundations for Male Teachers (MT) & Boys and Female Teachers (FT) & Girls, including all associated construction, sanitary, plumbing & electrical works under the Government Primary Schools Project funded by GoB.",
                'scope' => [
                    'Construction of all RCC and Masonry works including foundation, column, beam and slab',
                    'Supply and installation of all types of sanitary fittings and fixtures including plumbing works',
                    'Supply and installation of all types of electrical works',
                    'Adherence to public health and sanitation standards as directed by DPHE',
                ],
            ],
            [
                'title' => 'Water Pipeline Network Installation under GO4IMpact Project',
                'type' => 'construction',
                'client' => 'Eco-Social Development Organization (ESDO) – WaterAid',
                'location' => 'Dhamoirhat, Naogaon',
                'period' => '2025 – 2026',
                'contract_amount' => 1574893,
                'status' => 'completed',
                'is_featured' => true,
                'overview' => "Engaged to undertake construction of community water supply infrastructure under the GO4IMpact Project, a WaterAid-supported initiative aimed at expanding access to safe and reliable drinking water for underserved communities.",
                'scope' => [
                    'Construction of 2 piped water supply schemes to serve targeted communities',
                    'Design and construction of 2 RCC overhead water tank structures for reliable water storage and distribution',
                    'Installation of tap stands and meter boxes to facilitate equitable and metered water access',
                    'Establishment of a complete water distribution network connecting storage infrastructure to end users',
                ],
            ],
            [
                'title' => 'Installation of 120 Portable Toilets — National Parade Ground',
                'type' => 'construction',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'National Parade Ground, Dhaka',
                'period' => '2026',
                'contract_amount' => 602120,
                'status' => 'completed',
                'overview' => "Engaged to supply, install, and commission 120 portable toilet units at the National Parade Ground, demonstrating rapid, field-ready sanitation infrastructure delivery for high-profile public venues and mass gatherings.",
                'scope' => [
                    'Supply and installation of 120 portable toilet units using ring-slab, cloth and bamboo materials',
                    'Strategic placement across multiple designated locations within the National Parade Ground premises',
                    'Full commissioning and handover of sanitation facilities ensuring operational readiness',
                ],
            ],
            [
                'title' => 'Installation of 30 Portable Toilets — National Stadium, Gulistan',
                'type' => 'construction',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'National Stadium, Dhaka',
                'period' => '2025',
                'contract_amount' => 151490,
                'status' => 'completed',
                'overview' => 'Supply, installation and commissioning of 30 portable toilet units at the National Stadium premises in Gulistan.',
                'scope' => [
                    'Supply and installation of 30 portable toilet units constructed using ring-slab, cloth and bamboo materials',
                    'Strategic deployment across designated locations within stadium premises',
                    'Full commissioning and handover of sanitation units',
                ],
            ],
            [
                'title' => 'Installation of 20 Portable Toilets — Old Trade Fair Ground, Agargaon',
                'type' => 'construction',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'Trade Fair, Dhaka',
                'period' => '2025',
                'contract_amount' => 99015,
                'status' => 'completed',
                'overview' => 'Supply, installation and commissioning of 20 portable toilet units at the Old Trade Fair Ground Field, Agargaon, ensuring adequate public sanitation within the Trade Fair premises.',
                'scope' => [
                    'Supply and installation of 20 portable toilet units',
                    'Strategic placement across the Trade Fair Ground premises',
                    'Commissioning as per DPHE sanitation protocols',
                ],
            ],
            [
                'title' => 'Installation of 20 Portable Toilets — Sangsad Bhaban South Plaza',
                'type' => 'construction',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'Sangsad Bhaban South Plaza, Dhaka',
                'period' => '2025',
                'contract_amount' => 99385,
                'status' => 'completed',
                'overview' => 'Supply, installation and commissioning of 20 portable toilet units at the Sangsad Bhaban South Plaza, reinforcing the firm\'s track record of deploying sanitation infrastructure in high-profile public spaces.',
                'scope' => [
                    'Supply and installation of 20 portable toilet units',
                    'Strategic placement across the Sangsad Bhaban South Plaza premises',
                    'Strict adherence to public health and site-specific protocols',
                ],
            ],
            [
                'title' => 'Construction of Main Entry Gate — DPHE Nawabganj Sub-Divisional Office',
                'type' => 'construction',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'Nawabganj, Dhaka',
                'period' => '2025',
                'contract_amount' => 379541,
                'status' => 'completed',
                'overview' => 'Construction of the main entry gate at the DPHE Sub-Divisional Office in Nawabganj, enhancing security, functionality and visual identity of the government office premises.',
                'scope' => [
                    'Construction of RCC pillars serving as the structural foundation of the main entry gate',
                    'Supply and installation of stainless steel (SS) gates',
                    'Construction of all associated civil and structural infrastructure',
                ],
            ],
            [
                'title' => 'Construction of Office Internal Road — DPHE Dohar Upazila Office',
                'type' => 'construction',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'Dohar, Dhaka',
                'period' => '2025',
                'contract_amount' => 379896,
                'status' => 'completed',
                'overview' => 'Construction of the internal road network within the DPHE Dohar Upazila Office premises.',
                'scope' => [
                    'Construction of a durable RCC internal road within the office compound',
                    'Execution of all associated civil works and ancillary infrastructure',
                ],
            ],
            [
                'title' => 'Installation & Maintenance of Pipe Network — Sirajnagar, Sylhet',
                'type' => 'construction',
                'client' => 'IDE-Tetra Private Limited',
                'location' => 'Sirajnagar, Sylhet',
                'period' => '2024 – 2025',
                'contract_amount' => 217790,
                'status' => 'completed',
                'overview' => 'Design, installation and maintenance of a community pipe water network extending safe and reliable water supply access to local residents.',
                'scope' => [
                    'Design and construction of approximately 1 km of water pipe network',
                    'Installation of tap stands and meter boxes for structured, metered water access',
                    'Ongoing maintenance support for long-term operational reliability',
                ],
            ],

            // ---------------- Supply ----------------
            [
                'title' => 'Supply of Furniture for Divisional Offices — DPHE Dhaka Division',
                'type' => 'supply',
                'client' => 'Department of Public Health Engineering (DPHE)',
                'location' => 'Dhaka Division',
                'period' => '2024 – 2025',
                'status' => 'completed',
                'overview' => 'Supply, fitting and fixing of office furniture for DPHE divisional offices across Dhaka Division.',
                'scope' => [
                    'Supply, fitting and fixing of executive tables and chairs',
                    'Visitor chair supply and installation',
                ],
            ],
        ];

        $palettes = [
            ['#0f2436', '#0e7490'],
            ['#164e63', '#06b6d4'],
            ['#155e75', '#22d3ee'],
            ['#1e3a8a', '#0891b2'],
        ];

        foreach ($projects as $i => $data) {
            $documents = $data['documents'] ?? [];
            $packages = $data['packages'] ?? null;
            unset($data['documents'], $data['packages']);

            $file = 'projects/'.str($data['title'])->slug()->substr(0, 60).'.svg';
            $palette = $palettes[$i % count($palettes)];
            ImagePlaceholder::make(
                $file,
                str($data['title'])->limit(38, '…'),
                ($data['client'] ?? 'Innovus Mastermind'),
                $palette
            );
            $data['image_path'] = $file;
            $data['sort_order'] = $i;

            $project = Project::create($data);

            foreach ($documents as $doc) {
                if (! is_file($doc['file'])) {
                    continue;
                }

                $stored = 'projects/'.$project->id.'/documents/'.str($doc['title'])->slug().'.pdf';
                Storage::disk('public')->put($stored, file_get_contents($doc['file']));

                ProjectDocument::create([
                    'project_id' => $project->id,
                    'title' => $doc['title'],
                    'file_path' => $stored,
                    'size_bytes' => filesize($doc['file']),
                    'sort_order' => count($documents),
                ]);
            }

            if ($packages) {
                $project->update(['period' => trim(($project->period ?? '').' | Packages: '.$packages)]);
            }
        }
    }
}
