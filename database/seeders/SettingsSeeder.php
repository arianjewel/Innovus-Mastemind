<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Support\ImagePlaceholder;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Innovus Mastermind',
            'tagline' => 'Construction • Consultancy • Suppliers',
            'address' => 'KA-52/B, Bhuiyan Monjil, Middle Khilkhet, Dhaka-1229, Bangladesh',
            'phone_primary' => '+8801713956005',
            'email_primary' => 'innovusmastermind@gmail.com',
            'email_secondary' => 'arahman.ce86@gmail.com',
            'office_hours' => 'Saturday – Thursday: 9:00 AM – 6:00 PM',

            'about_intro' => implode("\n\n", [
                'Innovus Mastermind is a leading construction, consultancy, and supplier company in Bangladesh committed to delivering innovative, reliable, and sustainable engineering solutions. Since its establishment in 2021, the company has successfully completed various infrastructure, water management, structural design, and development projects for government organizations, NGOs, private companies, and development partners.',
                'We specialize in construction management, urban water management, structural design, urban planning, project supervision, supply solutions, and engineering consultancy services. Our multidisciplinary team combines technical expertise, practical field experience, and innovative thinking to provide world-class services.',
                '<strong>Building Sustainable Infrastructure with Innovation & Excellence.</strong>',
            ]),

            'about_vision' => 'To become one of the most trusted and innovative engineering, construction, and consultancy firms in Bangladesh by delivering sustainable infrastructure solutions that improve communities and create long-term value.',

            'about_mission' => implode("\n", [
                'To provide high-quality construction and consultancy services with professionalism and integrity.',
                'To ensure sustainable and cost-effective infrastructure development.',
                'To utilize innovation, engineering excellence, and modern technologies in every project.',
                'To build long-term relationships with clients through trust, quality, and timely delivery.',
                'To contribute to national development through safe, environmentally friendly, and resilient infrastructure.',
            ]),

            'core_values' => [
                'Integrity & Transparency',
                'Quality Assurance',
                'Innovation & Technology',
                'Sustainability',
                'Client Satisfaction',
                'Safety & Compliance',
                'Teamwork & Professionalism',
            ],

            'company_info' => [
                ['label' => 'Company Name', 'value' => 'Innovus Mastermind'],
                ['label' => 'Nature of Business', 'value' => '1st Class Contractor, Consultancy & Supplier'],
                ['label' => 'Establishment Year', 'value' => '2021'],
                ['label' => 'Business Type', 'value' => 'Proprietorship'],
                ['label' => 'Proprietor', 'value' => 'Md. Abdur Rahman'],
                ['label' => 'Trade License No.', 'value' => 'TRAD/DNCC/121425/2022'],
                ['label' => 'TIN', 'value' => '190710886915'],
                ['label' => 'BIN', 'value' => '0061088660101'],
                ['label' => 'DPHE Enlistment', 'value' => 'DPHE-DHAKA CIRCLE-207'],
                ['label' => 'Office Address', 'value' => 'KA-52/B, Bhuiyan Monjil, Middle Khilkhet, Dhaka-1229'],
            ],

            'stat_years_experience' => '14+',
            'stat_projects_completed' => '40+',
            'stat_experts' => '19',
            'stat_happy_clients' => '10+',

            'footer_text' => 'Building Sustainable Infrastructure with Innovation & Excellence — serving government organizations, NGOs, private companies, and development partners across Bangladesh.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, is_array($value) ? $value : trim($value));
        }

        ImagePlaceholder::make('site/logo.svg', 'Innovus Mastermind', 'Construction • Consultancy • Suppliers', ['#0e7490', '#164e63']);
    }
}
