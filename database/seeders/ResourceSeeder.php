<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        if (Resource::query()->exists()) {
            $this->command?->info('Resources already seeded, skipping.');
            return;
        }

        $resources = [
            [
                'title' => 'Pharmacy Valuation Calculator',
                'description' => 'Estimate an indicative value for a community pharmacy based on items dispensed, turnover and key market factors.',
                'type' => 'tool',
                'icon' => '📊',
                'category' => 'valuation',
                'resource_format' => 'internal_page',
                'is_premium' => false,
                'tags' => ['valuation', 'calculator', 'buying'],
            ],
            [
                'title' => 'Due Diligence Checklist',
                'description' => 'A 140-point checklist covering everything you should verify before submitting an offer on a pharmacy.',
                'type' => 'checklist',
                'icon' => '✅',
                'category' => 'buying',
                'resource_format' => 'download',
                'file_url' => 'resources/due-diligence-checklist.pdf',
                'is_premium' => false,
                'tags' => ['due diligence', 'buying', 'checklist'],
            ],
            [
                'title' => 'Business Plan Template (Bank Ready)',
                'description' => 'A bank-ready business plan template used by successful acquirers when applying for acquisition finance.',
                'type' => 'template',
                'icon' => '📝',
                'category' => 'finance',
                'resource_format' => 'download',
                'file_url' => 'resources/business-plan-template.docx',
                'is_premium' => true,
                'tags' => ['finance', 'business plan', 'template'],
            ],
            [
                'title' => 'Acquisition Finance Guide 2026',
                'description' => 'Walkthrough of the main acquisition finance routes, typical terms and how lenders evaluate a pharmacy deal.',
                'type' => 'guide',
                'icon' => '📖',
                'category' => 'finance',
                'resource_format' => 'download',
                'file_url' => 'resources/acquisition-finance-guide-2026.pdf',
                'is_premium' => false,
                'tags' => ['finance', 'guide', 'buying'],
            ],
            [
                'title' => 'Q1 2026 Market Report',
                'description' => 'Quarterly market report covering transaction volumes, price per item multiples and regional trends across the UK.',
                'type' => 'report',
                'icon' => '📈',
                'category' => 'valuation',
                'resource_format' => 'download',
                'file_url' => 'resources/market-report-q1-2026.pdf',
                'is_premium' => true,
                'tags' => ['market report', 'valuation', 'quarterly'],
            ],
            [
                'title' => 'GPhC Inspection Readiness Checklist',
                'description' => 'Pre-inspection checklist to help owners and managers prepare for a GPhC visit with confidence.',
                'type' => 'checklist',
                'icon' => '📋',
                'category' => 'compliance',
                'resource_format' => 'download',
                'file_url' => 'resources/gphc-inspection-checklist.pdf',
                'is_premium' => false,
                'tags' => ['gphc', 'compliance', 'checklist'],
            ],
            [
                'title' => 'Locum Contract Template',
                'description' => 'A plain-English locum contract template, suitable for both regular and ad-hoc locum bookings.',
                'type' => 'template',
                'icon' => '📝',
                'category' => 'hr',
                'resource_format' => 'download',
                'file_url' => 'resources/locum-contract-template.docx',
                'is_premium' => false,
                'tags' => ['locum', 'contract', 'hr'],
            ],
            [
                'title' => 'Pharmacy Owner Benchmarking Tool',
                'description' => 'Benchmark your pharmacy against UK averages on items, turnover, staff cost and profitability.',
                'type' => 'tool',
                'icon' => '📊',
                'category' => 'operations',
                'resource_format' => 'internal_page',
                'is_premium' => true,
                'tags' => ['benchmarking', 'operations', 'tool'],
            ],
        ];

        foreach ($resources as $resource) {
            Resource::create(array_merge($resource, [
                'status' => 'published',
                'download_count' => random_int(20, 1200),
            ]));
        }

        $this->command?->info('Seeded '.count($resources).' resources.');
    }
}
