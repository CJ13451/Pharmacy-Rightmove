<?php

namespace Database\Seeders;

use App\Enums\SupplierCategory;
use App\Enums\SupplierTier;
use App\Enums\UserRole;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        if (Supplier::query()->exists()) {
            $this->command?->info('Suppliers already seeded, skipping.');
            return;
        }

        $suppliers = [
            [
                'name' => 'AAH Pharmaceuticals',
                'category' => SupplierCategory::WHOLESALER,
                'tier' => SupplierTier::FEATURED,
                'short_description' => 'One of the UK\'s largest pharmaceutical wholesalers with twice-daily deliveries to community pharmacies nationwide.',
                'long_description' => 'AAH Pharmaceuticals is one of the leading full-line pharmaceutical wholesalers in the UK, supplying community pharmacies with branded, generic and OTC medicines from a nationwide network of distribution centres.',
                'website' => 'https://example.com/aah',
                'contact_email' => 'demo-aah@example.com',
                'contact_name' => 'AAH Account Team',
                'contact_phone' => '0344 561 8899',
                'address' => 'Sapphire Court, Coventry, CV3 4AB',
            ],
            [
                'name' => 'Alliance Healthcare',
                'category' => SupplierCategory::WHOLESALER,
                'tier' => SupplierTier::FEATURED,
                'short_description' => 'Full-line wholesaler with a UK-wide distribution network and a broad own-brand generics range.',
                'long_description' => 'Alliance Healthcare supplies medicines, consumer healthcare products and associated services to pharmacy customers across the UK from a nationwide logistics network.',
                'website' => 'https://example.com/alliance',
                'contact_email' => 'demo-alliance@example.com',
                'contact_name' => 'Alliance Sales Desk',
                'contact_phone' => '0345 610 0006',
                'address' => 'Alliance House, Chessington, KT9 2NY',
            ],
            [
                'name' => 'Cegedim Rx',
                'category' => SupplierCategory::PMR_SYSTEM,
                'tier' => SupplierTier::PREMIUM,
                'short_description' => 'Market-leading PMR system trusted by thousands of UK community pharmacies for dispensing and services.',
                'long_description' => 'Cegedim Rx provides pharmacy management solutions including the Pharmacy Manager PMR system, which is used by pharmacies across the UK to run their dispensing, services and retail operations.',
                'website' => 'https://example.com/cegedim',
                'contact_email' => 'demo-cegedim@example.com',
                'contact_name' => 'Cegedim Rx Sales',
                'contact_phone' => '0808 164 7142',
                'address' => 'Chapman House, Chertsey, KT16 9JX',
            ],
            [
                'name' => 'Numark',
                'category' => SupplierCategory::BUYING_GROUP,
                'tier' => SupplierTier::PREMIUM,
                'short_description' => 'The UK\'s largest independent pharmacy membership organisation, supporting owners with buying, branding and business development.',
                'long_description' => 'Numark is a membership organisation for independent community pharmacies, delivering preferential buying terms, marketing support and a wide range of member services.',
                'website' => 'https://example.com/numark',
                'contact_email' => 'demo-numark@example.com',
                'contact_name' => 'Numark Membership Team',
                'contact_phone' => '0800 783 5709',
                'address' => 'Numark House, Wellingborough, NN8 6GR',
            ],
            [
                'name' => 'Positive Solutions (Analyst)',
                'category' => SupplierCategory::PMR_SYSTEM,
                'tier' => SupplierTier::PREMIUM,
                'short_description' => 'Cloud-based PMR and analytics platform built specifically for ambitious independent pharmacy operators.',
                'long_description' => 'Positive Solutions provides Analyst, a cloud-based PMR and business intelligence platform designed for community pharmacy, with real-time reporting and integrated services modules.',
                'website' => 'https://example.com/positive-solutions',
                'contact_email' => 'demo-positive@example.com',
                'contact_phone' => '0191 691 1010',
                'contact_name' => 'Positive Solutions Team',
                'address' => 'Cobalt Business Park, Newcastle upon Tyne, NE27 0BY',
            ],
            [
                'name' => 'RB Pharmacy Fitout',
                'category' => SupplierCategory::FITOUT,
                'tier' => SupplierTier::PREMIUM,
                'short_description' => 'Specialist design and fitout contractor for community pharmacy refurbishments and new-build projects.',
                'long_description' => 'RB Pharmacy Fitout designs and delivers complete pharmacy refurbishments across the UK, from concept layouts and compliance sign-off through to installation and snagging.',
                'website' => 'https://example.com/rbfitout',
                'contact_email' => 'demo-rb@example.com',
                'contact_phone' => '0161 300 4455',
                'contact_name' => 'RB Projects Office',
                'address' => 'Salford Quays, Manchester, M50 3SP',
            ],
            [
                'name' => 'Hutchings Consultants',
                'category' => SupplierCategory::CONSULTING,
                'tier' => SupplierTier::PREMIUM,
                'short_description' => 'The UK\'s leading pharmacy-only business brokers, advising on acquisitions, disposals and valuations.',
                'long_description' => 'Hutchings Consultants is a specialist pharmacy brokerage advising independent and multiple operators on acquisitions, disposals, valuations and strategic reviews.',
                'website' => 'https://example.com/hutchings',
                'contact_email' => 'demo-hutchings@example.com',
                'contact_phone' => '01494 722 224',
                'contact_name' => 'Hutchings Deal Team',
                'address' => 'High Wycombe, Buckinghamshire, HP12 4AA',
            ],
            [
                'name' => 'Silver Levene LLP',
                'category' => SupplierCategory::ACCOUNTANT,
                'tier' => SupplierTier::PREMIUM,
                'short_description' => 'Chartered accountants specialising in community pharmacy — tax, benchmarking and owner-operator advice.',
                'long_description' => 'Silver Levene works with community pharmacy owners across the UK on accounts, tax, benchmarking and exit planning, providing sector-specific advice at every stage of ownership.',
                'website' => 'https://example.com/silverlevene',
                'contact_email' => 'demo-silverlevene@example.com',
                'contact_phone' => '020 7383 3200',
                'contact_name' => 'Silver Levene Pharmacy Team',
                'address' => '37 Warren Street, London, W1T 6AD',
            ],
            [
                'name' => 'Charles Russell Speechlys',
                'category' => SupplierCategory::LEGAL,
                'tier' => SupplierTier::FREE,
                'short_description' => 'Sector-experienced legal team covering pharmacy sales, leases, employment and regulatory work.',
                'website' => 'https://example.com/crs',
                'contact_email' => 'demo-crs@example.com',
            ],
            [
                'name' => 'Phoenix Insurance Services',
                'category' => SupplierCategory::INSURANCE,
                'tier' => SupplierTier::FREE,
                'short_description' => 'Tailored insurance products for community pharmacy — professional indemnity, property and business interruption.',
                'website' => 'https://example.com/phoenix-ins',
                'contact_email' => 'demo-phoenix@example.com',
            ],
            [
                'name' => 'Pharmacy Recruit',
                'category' => SupplierCategory::RECRUITMENT,
                'tier' => SupplierTier::FREE,
                'short_description' => 'Permanent and locum recruitment across pharmacist, technician and dispenser roles UK-wide.',
                'website' => 'https://example.com/pharmacyrecruit',
                'contact_email' => 'demo-recruit@example.com',
            ],
            [
                'name' => 'CPD Pharmacy Training',
                'category' => SupplierCategory::TRAINING,
                'tier' => SupplierTier::FREE,
                'short_description' => 'Accredited e-learning and face-to-face training for pharmacists, technicians and counter assistants.',
                'website' => 'https://example.com/cpdtraining',
                'contact_email' => 'demo-cpdtraining@example.com',
            ],
            [
                'name' => 'Till Point EPOS',
                'category' => SupplierCategory::EPOS,
                'tier' => SupplierTier::FREE,
                'short_description' => 'Pharmacy-ready EPOS and stock control that integrates with the main UK PMR systems.',
                'website' => 'https://example.com/tillpoint',
                'contact_email' => 'demo-tillpoint@example.com',
            ],
            [
                'name' => 'Bluebird Consulting',
                'category' => SupplierCategory::CONSULTING,
                'tier' => SupplierTier::FREE,
                'short_description' => 'Independent operations and services consultancy for pharmacy owners who want to grow clinical income.',
                'website' => 'https://example.com/bluebird',
                'contact_email' => 'demo-bluebird@example.com',
            ],
        ];

        $seeded = 0;

        foreach ($suppliers as $index => $data) {
            $tier = $data['tier'];

            $role = match ($tier) {
                SupplierTier::FEATURED => UserRole::SUPPLIER_FEATURED,
                SupplierTier::PREMIUM => UserRole::SUPPLIER_PREMIUM,
                default => UserRole::SUPPLIER_FREE,
            };

            $email = 'demo-supplier-'.Str::slug($data['name']).'@example.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'password' => Hash::make('password'),
                    'first_name' => explode(' ', $data['name'])[0] ?? 'Supplier',
                    'last_name' => 'Team',
                    'job_title' => 'supplier_vendor',
                    'currently_own_pharmacy' => false,
                    'looking_to_buy' => false,
                    'role' => $role,
                    'newsletter_subscribed' => false,
                    'email_verified_at' => now(),
                ]
            );

            Supplier::create([
                'user_id' => $user->id,
                'status' => 'active',
                'tier' => $tier,
                'subscription_status' => $tier === SupplierTier::FREE ? 'none' : 'active',
                'name' => $data['name'],
                'category' => $data['category'],
                'short_description' => $data['short_description'],
                'long_description' => $data['long_description'] ?? null,
                'contact_email' => $data['contact_email'],
                'contact_name' => $data['contact_name'] ?? null,
                'contact_phone' => $data['contact_phone'] ?? null,
                'website' => $data['website'] ?? null,
                'address' => $data['address'] ?? null,
                'views_count' => random_int(50, 2500),
                'clicks_count' => random_int(10, 400),
            ]);

            $seeded++;
        }

        $this->command?->info("Seeded {$seeded} suppliers.");
    }
}
