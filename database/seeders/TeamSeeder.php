<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use App\Support\ImagePlaceholder;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            // ---------------- Leadership ----------------
            [
                'name' => 'Md. Abdur Rahman',
                'designation' => 'Founder & Managing Director',
                'type' => 'leadership',
                'qualification' => 'MSc in Water Resources Engineering (BUET), BSc in Civil Engineering (DUET), MIEB: 33248',
                'expertise' => 'Structural Design, Drainage, Water Resource Management, Hydraulic Modelling, Team Leading',
                'experience' => '14+ Years',
                'bio' => "Md. Abdur Rahman is the Founder and Managing Director of Innovus Mastermind and a highly experienced Civil and Water Resources Engineer with over 14 years of expertise in water supply engineering, hydraulic modelling, structural design, and infrastructure development.\n\nHe has worked with renowned organizations including DPHE, Institute of Water Modelling (IWM), and Nahda Builders Ltd., contributing to major national projects in water supply, drainage, sanitation, flood management, and structural engineering. His expertise includes WaterGEMS, MIKE URBAN, ETABS, ArcGIS, and project management.",
                'highlights' => [
                    'Rural Water, Sanitation and Hygiene for Human Capital Development (RWSHHCD) Project (GoB–World Bank)',
                    'Water Supply Network Design — Tetuljhora-Bhakurta Well Field Project Area',
                    'Water Demand & Availability Assessment for Naf (Jaliardwip Island) and Sabrang Tourism Park',
                    'Design & Construction Supervision of Water Treatment Plant with Intake and Transmission Mains',
                    'Water Demand Assessment for Bangabandhu Sheikh Mujib Shilpa Nagar (BSMSN)',
                    'Stormwater drainage analysis for Bangladesh Chinese Economic Industrial Park',
                    'Feasibility Study with Detail Design of Surface Water Treatment Plant for Sylhet City Corporation',
                    'Relocation of 400mm Water Transmission Pipeline — Bangla Motor to Nilkhet',
                    'Road and Drainage Network Improvement in Extended DNCC Area',
                    'Flood Control & Drainage Study — Dhaka Circular Road (Eastern Bypass) Project',
                    'Assessment of State of Water Resources in Bangladesh',
                    'Flood Modelling of Dhaka City Part-2 (DWSSP)',
                    'Water Supply Master Plan for Dhaka City',
                    'Survey of 16 Rivers for FSCD under Capital Dredging Project',
                    'Drainage Improvement Feasibility of Polders 1, 2, 6-8 — Satkhira District',
                ],
                'file' => 'team/md-abdur-rahman.svg',
            ],
            [
                'name' => 'Fuad Hasan Ovi',
                'designation' => 'Director',
                'type' => 'leadership',
                'qualification' => 'BURP (BUET), Masters in Environmental Science and Management (BUP), BIP: AM-987',
                'expertise' => 'Urban Planning, GIS, Hydraulic Modelling, Water Network Design, Team Leading',
                'experience' => '12+ Years',
                'bio' => "Fuad Hasan Ovi is the Director of Innovus Mastermind and an experienced Urban Planner, Hydraulic Modelling and GIS Specialist with over 12 years of professional experience in urban infrastructure planning, GIS analysis, stormwater management, and water supply network design.\n\nHe has served in leading organizations including NAWE Infrastructure Bangladesh Pvt. Ltd., Institute of Water Modelling (IWM), and Sheltech Consultancy Ltd., working on national and international projects related to DMA concepts in water supply systems, water network modelling and design, sewerage network design, stormwater systems, feasibility studies and urban infrastructure.",
                'highlights' => [
                    'Chittagong Water Supply Improvement and Sanitation Project S-3 (World Bank)',
                    'Dhaka Water Supply Sector Development Project (ADB)',
                    'Flood Control & Drainage Study — Dhaka Circular Road (Eastern Bypass) Project',
                    'Roads, Drainage & Footpath Design for 18 New DNCC Wards',
                    'Dhaka Environmentally Sustainable Water Supply Project (ADB)',
                    'Water Supply Network with DMA Concept — Uttara Model Town (3rd Phase)',
                    'Feasibility for Water Distribution in 16 New Unions of DNCC & DSCC',
                    'Land Use Master Plan for 8 New Unions of Dhaka South City Corporation',
                    'Pagla Sewerage Treatment Plant Supervision Project',
                    'Teknaf Paurashava WASH Monitoring & Supervision (World Bank)',
                    'Gap Analysis for FSM/SWM Systems — ESMP Development (EMCRP/SD-15.1)',
                    'Detailed design of stormwater, sewerage and water supply networks for municipalities in Sweden (remote international teams)',
                ],
                'file' => 'team/fuad-hasan-ovi.svg',
            ],

            // ---------------- Staff ----------------
            [
                'name' => 'Rita Khatun',
                'designation' => 'Structural Engineer',
                'type' => 'staff',
                'qualification' => 'BSc in Civil Engineering (DUET)',
                'expertise' => 'Structural Design, BOQ Preparation, Supervision',
                'experience' => '7 Years',
                'file' => 'team/rita-khatun.svg',
            ],
            [
                'name' => 'S.M. Alymuzzaman',
                'designation' => 'Project Engineer',
                'type' => 'staff',
                'qualification' => 'BSc in Civil Engineering',
                'expertise' => 'Project Engineering & Site Management',
                'experience' => '5 Years',
                'file' => 'team/sm-alymuzzaman.svg',
            ],
            [
                'name' => 'Md. Rakibuzzaman',
                'designation' => 'Survey Officer',
                'type' => 'staff',
                'qualification' => 'Diploma in Civil Engineering',
                'expertise' => 'Survey & Data Processing',
                'experience' => '4 Years',
                'file' => 'team/md-rakibuzzaman.svg',
            ],
            [
                'name' => 'Md. Parvez',
                'designation' => 'Survey Officer',
                'type' => 'staff',
                'qualification' => 'Diploma in Civil Engineering',
                'expertise' => 'Survey & Data Processing',
                'experience' => '2 Years',
                'file' => 'team/md-parvez.svg',
            ],
            [
                'name' => 'Fahim Mahmud Asif',
                'designation' => 'Site Coordinator (GIS)',
                'type' => 'staff',
                'qualification' => 'HSC',
                'expertise' => 'Site Support & Coordination, GIS',
                'experience' => '3 Years',
                'file' => 'team/fahim-mahmud-asif.svg',
            ],

            // ---------------- Consultant Panel ----------------
            [
                'name' => 'Dr. Syed Zakir Hossein',
                'designation' => 'Senior Drainage, Hydrology & Hydraulic Modelling Specialist / River Morphology Expert',
                'type' => 'consultant',
                'qualification' => 'PhD in Civil & Environmental Engineering, Incheon National University, Republic of Korea',
                'expertise' => 'Hydrology, Hydraulic modelling, River Morphology, Research, Team Leading',
                'experience' => '20+ Years',
                'bio' => "Dr. Syed Zakir Hossein has more than 20 years of experience in hydrology, drainage, hydraulic and hydrodynamic modelling, river morphology, water resources, watershed management and urban water systems. His professional record includes assignments with ADB, World Bank, JICA, UN agencies, CWASA and DNCC/NCC-related urban drainage initiatives.",
                'highlights' => [
                    'Flood & Drainage Specialist — World Bank/BWDB Dhaka Eastern Bypass studies (1D–2D flood modelling, flood-risk mapping)',
                    'River Morphology Expert — World Bank Jal Marg Vikas Project, India (Ganges morphology, bathymetry, dredging)',
                    'Drainage Engineer — ADB Narayanganj City Corporation Urban Infrastructure Facility',
                    'Senior Hydraulic Modeller — World Bank Chattogram WASH Improvement Project',
                    'Hydrologist — CARE ecological assessment, Sundarbans & Hakaluki Haor ECAs',
                    'Municipal Engineer — Cox\'s Bazar Development Authority Smart City Master Plan',
                ],
                'file' => 'team/dr-syed-zakir-hossein.svg',
            ],
            [
                'name' => 'Umme Farwa Daisy',
                'designation' => 'Institutional Assessment, WASH, GESI & Capacity-Building Specialist',
                'type' => 'consultant',
                'qualification' => 'M.Sc. in Psychology, Rajshahi University; Certificate in Institutional & HR Development, Copenhagen Development Consulting, Denmark',
                'expertise' => 'CWIS, FSM/SWM, WASH planning, institutional assessment, GESI, capacity building',
                'experience' => '30+ Years',
                'bio' => "Ms. Umme Farwa Daisy has more than 36 years of experience in WASH, health, gender, communication, institutional assessment and participatory planning with government, national and international organizations, including DPHE, the World Bank, UNICEF and WaterAid.",
                'highlights' => [
                    'Gender Consultant — DPHE-Danida WSS Project (gender guidelines, hygiene promotion action research)',
                    'DD & Project Manager WASH — Dhaka Ahsania Mission',
                    'Short-Term Consultant — World Bank (rural sanitation planning for DPHE & PKSF)',
                    'Institutional Capacity Assessment — icddr,b & UNICEF (Cox\'s Bazar participatory WASH planning)',
                    'Study Consultant — DSK & UNICEF city-wide WASH baseline survey, Cox\'s Bazar',
                    'Institutional & GESI Expert — Global Water & Sanitation Center, AIT (CWIS assessment of nine towns)',
                ],
                'file' => 'team/umme-farwa-daisy.svg',
            ],
            [
                'name' => 'Farhana Sharmin',
                'designation' => 'Senior Environmental, Climate Resilience & Social Safeguards Specialist',
                'type' => 'consultant',
                'qualification' => 'PhD, Jahangirnagar University; M.Sc. in Water Resource Development (BUET/IWFM); M.Sc. in Environmental Science',
                'expertise' => 'Environmental assessment, climate adaptation, disaster risk reduction, social safeguards',
                'experience' => '25+ Years',
                'bio' => "Farhana Sharmin has more than 25 years of experience in environmental assessment, climate adaptation, disaster risk reduction, social safeguards, community resilience, participatory assessment and environmental management across government, development partners, NGOs and international organizations.",
                'highlights' => [
                    'Programme Manager/Climate Focal Person — Practical Action Bangladesh',
                    'Climate Change & DRR Expert — BMD Weather Index Based Crop Insurance pilot',
                    'Climate & Environmental Expert — Oxfam REE-CALL Project',
                    'Environmental & Social Safeguards Specialist — LGSP-II (ESMF compliance)',
                    'Environmental Management Specialist — DNCC Dhaka Integrated Urban Development Project',
                    'Senior Environmentalist — Dhaka Subway feasibility study (EIA & EMP)',
                ],
                'file' => 'team/farhana-sharmin.svg',
            ],
            [
                'name' => 'Md. Imran Mahmood',
                'designation' => 'Senior Hydrogeologist / Groundwater Development & Water-Well Specialist',
                'type' => 'consultant',
                'qualification' => 'M.Sc. in Geological Sciences, Jahangirnagar University',
                'expertise' => 'Aquifer assessment, production-well design, drilling supervision, pumping tests, groundwater quality',
                'experience' => '30+ Years',
                'bio' => "Md. Imran Mahmood has more than 30 years of professional experience in groundwater development and water-well engineering covering aquifer assessment, hydrogeological investigations, production-well design, drilling and supervision, borehole logging, well development and groundwater monitoring.",
                'highlights' => [
                    '18-District Water Supply & Sanitation Project — Moulvibazar/Sylhet deep water wells',
                    'Long-term DWASA water-supply projects — numerous deep tube wells in Dhaka',
                    'Hydrogeologist — Prime Engineering & Sama Engineering (drilling, testing, aquifer assessment)',
                    'Senior Hydrogeologist — Savar well-field works (geophysical logging, well development)',
                    'Senior Hydrogeologist/PM — DWASA Interim Water Supply Project',
                    'Consultant Hydrogeologist — RWSHHCD Project (GoB–World Bank–AIIB)',
                ],
                'file' => 'team/md-imran-mahmood.svg',
            ],
            [
                'name' => 'Md. Aminul Islam',
                'designation' => 'Senior Economist / Agro-Economist',
                'type' => 'consultant',
                'qualification' => 'M.A. in Economics, University of Rajshahi',
                'expertise' => 'Agro-economics; Economic & Financial Analysis; BCR/EIRR/NPV; DPP/RDPP; Feasibility; Socio-Economic Assessment',
                'experience' => '45+ Years',
                'bio' => "Mr. Md. Aminul Islam has more than 45 years of professional experience including long-term service with BWDB. His expertise covers economic and financial analysis, feasibility studies, DPP/RDPP preparation, socio-economic assessment, irrigation, drainage, flood and riverbank erosion management.",
                'highlights' => [
                    'Economic/Financial Analyst — flood & riverbank erosion risk management projects',
                    'Economist — drainage improvement and river/polder restoration, Khulna',
                    'DPP Formulation Consultant — Haor Risk Management Development Project',
                    'Economist — Southwest Area Integrated Water Resources Planning Project',
                    'Economist Analyst — sewerage infrastructure feasibility (BCR, IRR, NPV modelling)',
                    'Socio-Economic Specialist — Jamuna River Economic Corridor Development Program',
                    'Senior Agriculture Economist — Climate Disaster Resilient Small Scale WRMP (42 districts)',
                ],
                'file' => 'team/md-aminul-islam.svg',
            ],
            [
                'name' => 'Dr. S. M. Atikullah',
                'designation' => 'Agriculture, Climate Resilience & Participatory Development Specialist',
                'type' => 'consultant',
                'qualification' => 'PhD, Jahangirnagar University; M.Sc. (Ag.) in Agriculture Extension Education, BAU',
                'expertise' => 'Agronomy, climate-resilient livelihoods, participatory water management, PRA/FGD/KII, feasibility & impact assessment',
                'experience' => '30+ Years',
                'bio' => "Dr. S. M. Atikullah's professional record covers agriculture, water management, climate-resilient livelihoods, environmental and social assessment, participatory planning, land zoning, agribusiness and natural-resource management.",
                'highlights' => [
                    'Feasibility & natural-resource studies — Meghna Estuary chars, Karnaphuli-Halda basin',
                    'Agriculture Specialist — National Land Zoning Project',
                    'National Consultant (UNDP) — Climate Resilient Livelihood Specialist',
                    'Consultant Agronomy — irrigation improvement & sustainable agriculture feasibility',
                    'Agriculture Expert/Agronomist — IWM hydro-morphological model studies',
                ],
                'file' => 'team/dr-sm-atikullah.svg',
            ],
            [
                'name' => 'Ghiasuddin Ahmad',
                'designation' => 'Senior Civil & Water Resources Specialist / Team Leader',
                'type' => 'consultant',
                'qualification' => 'B.Sc. Engineering (Civil), CUET',
                'expertise' => 'Coastal polders, hydraulic/water infrastructure, dredging, embankment & riverbank works, construction supervision',
                'experience' => '45+ Years',
                'bio' => "Mr. Ghiasuddin Ahmad is a B.Sc. Civil Engineer from CUET with more than four decades of experience in water resources, coastal polders, hydraulic infrastructure, embankments, drainage, dredging and construction supervision — holding Team Leader, Construction Supervision Engineer, Senior Embankment Engineer, Dredging Specialist and Senior Water Resources Specialist roles.",
                'highlights' => [
                    'Team Leader — Dhaka WASA khal project (survey monitoring, modelling/planning leadership)',
                    'Senior Water Resources Specialist — National Water Management Plan update',
                    'Dredging Specialist — Bhabodah beel drainage improvement',
                    'Construction Supervision — CEIP-1 drainage sluices, embankments & riverbank protection (BWDB/World Bank)',
                    'Team Leader — re-excavation & beautification of four khals, Dhaka South City Corporation (2024–present)',
                ],
                'file' => 'team/ghiasuddin-ahmad.svg',
            ],
        ];

        foreach ($members as $i => $member) {
            ImagePlaceholder::make(
                $member['file'],
                $member['name'],
                $member['designation'] ?? '',
                ['#152f47', '#0e7490']
            );

            TeamMember::create([
                'name' => $member['name'],
                'designation' => $member['designation'] ?? null,
                'type' => $member['type'],
                'qualification' => $member['qualification'] ?? null,
                'expertise' => $member['expertise'] ?? null,
                'experience' => $member['experience'] ?? null,
                'bio' => $member['bio'] ?? null,
                'highlights' => $member['highlights'] ?? null,
                'photo_path' => $member['file'],
                'sort_order' => $i,
                'is_active' => true,
            ]);
        }
    }
}
