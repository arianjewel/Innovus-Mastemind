<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Support\ImagePlaceholder;
use Illuminate\Database\Seeder;

class ProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------- Categories ----------------
        $categories = [
            ['name' => 'Pipes & Fittings', 'description' => 'HDPE, PVC and GI pipes with all fittings for water supply networks'],
            ['name' => 'Pumps & Water Equipment', 'description' => 'Water pumps, submersible pumps and water supply equipment'],
            ['name' => 'Construction Machinery', 'description' => 'Concrete mixers, vibrators, cutting & welding machines'],
            ['name' => 'Survey Instruments', 'description' => 'Total stations, GPS and precision measuring equipment'],
            ['name' => 'Sanitary Ware', 'description' => 'Sanitary fittings, fixtures and bathroom accessories'],
            ['name' => 'Safety Equipment', 'description' => 'PPE, helmets, safety gear for construction sites'],
        ];

        $catIds = [];
        foreach ($categories as $i => $c) {
            $file = 'categories/'.str($c['name'])->slug().'.svg';
            ImagePlaceholder::make($file, $c['name'], 'Product Category', ['#0e7490', '#155e75']);

            $cat = Category::create($c + [
                'image_path' => $file,
                'sort_order' => $i,
                'is_active' => true,
            ]);
            $catIds[$c['name']] = $cat->id;
        }

        // ---------------- Brands ----------------
        $brands = ['RFL', 'Star Pipes', 'Shah Cement', 'Bosch', 'Topcon', '3M'];
        $brandIds = [];
        foreach ($brands as $i => $name) {
            $file = 'brands/'.str($name)->slug().'.svg';
            ImagePlaceholder::make($file, $name, '', ['#1f2937', '#374151']);

            $brand = Brand::create([
                'name' => $name,
                'logo_path' => $file,
                'sort_order' => $i,
                'is_active' => true,
            ]);
            $brandIds[$name] = $brand->id;
        }

        // ---------------- Products ----------------
        $products = [
            [
                'title' => 'HDPE Pipe PN10 (20mm – 315mm)',
                'category' => 'Pipes & Fittings',
                'brand' => 'RFL',
                'price' => 185.00,
                'old_price' => 210.00,
                'unit' => 'meter',
                'sku' => 'IM-PIPE-HDPE-010',
                'short_desc' => 'High-density polyethylene pipe PN10 for potable water supply networks. Available in 20mm to 315mm diameters.',
                'details' => "HDPE pipes are the industry standard for modern water supply distribution networks — corrosion-free, flexible, leak-proof electrofusion/butt-fusion joining and a service life of 50+ years.\n\nIdeal for mini piped water supply schemes, rural water projects and camp WASH infrastructure. Supplied in standard coils or 6m/12m lengths as per diameter.",
                'specifications' => [
                    ['label' => 'Material', 'value' => 'High-Density Polyethylene (PE100)'],
                    ['label' => 'Pressure Rating', 'value' => 'PN10 (10 bar)'],
                    ['label' => 'Diameter Range', 'value' => '20mm – 315mm'],
                    ['label' => 'Standard', 'value' => 'ISO 4427 / BS EN 12201'],
                    ['label' => 'Color', 'value' => 'Black with blue stripe'],
                    ['label' => 'Jointing Method', 'value' => 'Butt fusion / Electrofusion / Compression fittings'],
                ],
                'featured' => true,
            ],
            [
                'title' => 'PVC-u Pipe Class C (½" – 8")',
                'category' => 'Pipes & Fittings',
                'brand' => 'Star Pipes',
                'price' => 95.00,
                'unit' => 'length',
                'sku' => 'IM-PIPE-PVC-C',
                'short_desc' => 'Unplasticized PVC pressure pipe Class C for water supply and distribution lines.',
                'details' => "Rigid PVC-u pressure pipes suitable for underground and exposed water supply installations. Light weight, easy solvent-cement jointing, smooth bore for minimal head loss.",
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Unplasticized Polyvinyl Chloride (PVC-u)'],
                    ['label' => 'Class', 'value' => 'Class C (15 bar)'],
                    ['label' => 'Size Range', 'value' => '½ inch – 8 inch'],
                    ['label' => 'Standard Length', 'value' => '6 meters (20 ft)'],
                    ['label' => 'Standard', 'value' => 'BS 3505 / ASTM D1785'],
                ],
            ],
            [
                'title' => 'GI Pipe Medium Class (¾" – 4")',
                'category' => 'Pipes & Fittings',
                'brand' => null,
                'price' => 320.00,
                'unit' => 'length',
                'sku' => 'IM-PIPE-GI-M',
                'short_desc' => 'Galvanized iron pipe medium class for water transmission and plumbing works.',
                'details' => "Hot-dip galvanized steel pipes providing robust mechanical strength for exposed plumbing runs, riser pipes and transmission mains where impact resistance is required.",
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Mild steel, hot-dip galvanized'],
                    ['label' => 'Class', 'value' => 'Medium (B-class)'],
                    ['label' => 'Size Range', 'value' => '¾ inch – 4 inch'],
                    ['label' => 'Standard', 'value' => 'BS 1387 / IS 1239'],
                    ['label' => 'Length', 'value' => '6 meters (19.5 ft)'],
                ],
            ],
            [
                'title' => 'Submersible Pump 2HP (Deep Well)',
                'category' => 'Pumps & Water Equipment',
                'brand' => null,
                'price' => 28500.00,
                'old_price' => 31000.00,
                'unit' => 'pcs',
                'sku' => 'IM-PUMP-SUB-2HP',
                'short_desc' => 'Stainless steel submersible deep-well pump set for production wells and water supply schemes.',
                'details' => "Complete submersible pumpset with motor, cable and control box — engineered for continuous duty in deep tubewells of rural and urban water supply schemes.",
                'specifications' => [
                    ['label' => 'Power', 'value' => '2 HP (1.5 kW), 3-phase 415V'],
                    ['label' => 'Discharge Range', 'value' => '5 – 25 m³/hr'],
                    ['label' => 'Max Head', 'value' => '120 m'],
                    ['label' => 'Casing', 'value' => 'Stainless Steel 304'],
                    ['label' => 'Bore Size', 'value' => '4 inch minimum well diameter'],
                ],
                'featured' => true,
            ],
            [
                'title' => 'Concrete Mixer Machine 10/7 CFT',
                'category' => 'Construction Machinery',
                'brand' => null,
                'price' => 96000.00,
                'unit' => 'pcs',
                'sku' => 'IM-MCH-MIXER-107',
                'short_desc' => 'Heavy-duty half-bag concrete mixer with hoist, ideal for building construction sites.',
                'details' => "Robust 10/7 CFT (half-bag) concrete mixer machine with mechanical hopper hoist. Fitted with premium drum and gear assembly for long service life on demanding sites.",
                'specifications' => [
                    ['label' => 'Drum Capacity', 'value' => '10/7 CFT (unmixed/mixed)'],
                    ['label' => 'Power', 'value' => '5 HP electric motor / diesel option'],
                    ['label' => 'Frame', 'value' => 'Heavy steel channel chassis with wheels'],
                    ['label' => 'Batch Time', 'value' => '~2 minutes'],
                ],
                'featured' => true,
            ],
            [
                'title' => 'Needle Vibrator 40mm',
                'category' => 'Construction Machinery',
                'brand' => 'Bosch',
                'price' => 14500.00,
                'unit' => 'pcs',
                'sku' => 'IM-MCH-VIB-040',
                'short_desc' => 'High-frequency concrete needle vibrator for proper compaction of RCC works.',
                'details' => "Portable petrol/electric needle vibrator ensuring dense, void-free concrete compaction in columns, beams and slabs.",
                'specifications' => [
                    ['label' => 'Needle Diameter', 'value' => '40 mm'],
                    ['label' => 'Frequency', 'value' => '12,000 vpm'],
                    ['label' => 'Power Source', 'value' => 'Petrol engine / 220V electric'],
                    ['label' => 'Flexible Shaft', 'value' => '5 m standard'],
                ],
            ],
            [
                'title' => 'Total Station Survey Instrument',
                'category' => 'Survey Instruments',
                'brand' => 'Topcon',
                'price' => 450000.00,
                'old_price' => 480000.00,
                'unit' => 'set',
                'sku' => 'IM-SUR-TS-TOP',
                'short_desc' => 'Precision total station for topographic survey, layout and as-built documentation.',
                'details' => "Complete total station kit with tripod, prism pole and accessories — used by our own survey teams for pipeline alignment, topographic surveys and construction layout.",
                'specifications' => [
                    ['label' => 'Angular Accuracy', 'value' => '2" angle measurement'],
                    ['label' => 'Distance Accuracy', 'value' => '±(2mm + 2ppm × D)'],
                    ['label' => 'Range', 'value' => '3,000 m to single prism'],
                    ['label' => 'Memory', 'value' => '50,000 points internal + SD card'],
                    ['label' => 'Includes', 'value' => 'Tripod, prisms, battery, charger, carry case'],
                ],
                'featured' => true,
            ],
            [
                'title' => 'Handheld GPS Navigator',
                'category' => 'Survey Instruments',
                'brand' => null,
                'price' => 22000.00,
                'unit' => 'pcs',
                'sku' => 'IM-SUR-GPS-HH',
                'short_desc' => 'Rugged handheld GPS device for field mapping and GIS data collection.',
                'details' => "Waterproof handheld GNSS receiver supporting GPS/GLONASS with high-sensitivity antenna — perfect for household survey mapping, network asset tagging and field verification.",
                'specifications' => [
                    ['label' => 'Receiver', 'value' => 'GPS + GLONASS, WAAS/EGNOS'],
                    ['label' => 'Accuracy', 'value' => '3 m typical (1 m with external antenna)'],
                    ['label' => 'Display', 'value' => '2.6 inch color transflective TFT'],
                    ['label' => 'Battery Life', 'value' => '16–20 hours (AA ×2)'],
                ],
            ],
            [
                'title' => 'Porcelain Wash Basin Set',
                'category' => 'Sanitary Ware',
                'brand' => 'RFL',
                'price' => 3850.00,
                'unit' => 'set',
                'sku' => 'IM-SAN-BASIN-P01',
                'short_desc' => 'Complete porcelain wash basin set with pillar tap, waste trap and fittings.',
                'details' => "Grade-A vitreous china wash basin with concealed bracket support. Complete installation set including chrome-plated brass pillar tap, bottle trap and connection hoses.",
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Vitreous china porcelain'],
                    ['label' => 'Size', 'value' => '24" × 16" standard'],
                    ['label' => 'Tap Finish', 'value' => 'Chrome plated brass'],
                    ['label' => 'Warranty', 'value' => '5 years manufacturer'],
                ],
            ],
            [
                'title' => 'Squatting Pan (Long Pan) with Trap',
                'category' => 'Sanitary Ware',
                'brand' => null,
                'price' => 1250.00,
                'unit' => 'pcs',
                'sku' => 'IM-SAN-SQ-L02',
                'short_desc' => 'Ceramic squatting pan with integrated water seal trap for sanitation facilities.',
                'details' => "Durable ceramic long pan widely used in school WASH blocks and public sanitation facilities. Integrated P-trap ensures effective odor seal.",
                'specifications' => [
                    ['label' => 'Material', 'value' => 'Glazed ceramic'],
                    ['label' => 'Type', 'value' => 'Long pan with integral trap'],
                    ['label' => 'Water Seal', 'value' => '50 mm minimum'],
                ],
            ],
            [
                'title' => 'Industrial Safety Helmet (ANSI Certified)',
                'category' => 'Safety Equipment',
                'brand' => '3M',
                'price' => 850.00,
                'unit' => 'pcs',
                'sku' => 'IM-SAF-HLM-A01',
                'short_desc' => 'ANSI Z89.1 certified HDPE safety helmet with ratchet adjustment and chin strap.',
                'details' => "Site-proven safety helmet meeting ANSI Z89.1 Type I requirements. Ratchet size adjustment, sweat-absorbent lining and 4-point suspension system.",
                'specifications' => [
                    ['label' => 'Standard', 'value' => 'ANSI Z89.1 Type I / EN 397'],
                    ['label' => 'Shell Material', 'value' => 'UV-stabilized HDPE'],
                    ['label' => 'Suspension', 'value' => '4-point textile suspension'],
                    ['label' => 'Colors Available', 'value' => 'White, Yellow, Blue, Red'],
                ],
            ],
            [
                'title' => 'Safety Vest Reflective (Hi-Vis)',
                'category' => 'Safety Equipment',
                'brand' => '3M',
                'price' => 420.00,
                'unit' => 'pcs',
                'sku' => 'IM-SAF-VST-R02',
                'short_desc' => 'High-visibility reflective safety vest with 2-inch reflective tape strips.',
                'details' => "Breathable polyester mesh vest with 360° visibility reflective tape — mandatory PPE for night works and roadside operations.",
                'specifications' => [
                    ['label' => 'Fabric', 'value' => 'Polyester mesh 120 gsm'],
                    ['label' => 'Reflective Tape', 'value' => '2 inch, 360° coverage'],
                    ['label' => 'Closure', 'value' => 'Hook & loop front'],
                    ['label' => 'Standard', 'value' => 'EN ISO 20471 Class 2'],
                ],
            ],
        ];

        foreach ($products as $i => $p) {
            $product = Product::create([
                'title' => $p['title'],
                'category_id' => $catIds[$p['category']] ?? null,
                'brand_id' => $p['brand'] ? ($brandIds[$p['brand']] ?? null) : null,
                'sku' => $p['sku'],
                'price' => $p['price'],
                'old_price' => $p['old_price'] ?? null,
                'unit' => $p['unit'],
                'currency' => 'BDT',
                'short_desc' => $p['short_desc'],
                'details' => $p['details'],
                'specifications' => $p['specifications'],
                'is_featured' => $p['featured'] ?? false,
                'is_active' => true,
                'views' => random_int(5, 120),
                'sort_order' => $i,
            ]);

            $file = "products/{$product->id}/".str($p['title'])->slug().'-a.svg';
            ImagePlaceholder::make(
                $file,
                str($p['title'])->limit(34, '…'),
                ($p['brand'] ? $p['brand'].' • ' : '').$p['category'],
                ['#152f47', '#0e7490']
            );

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $file,
                'sort_order' => 0,
            ]);
        }
    }
}
