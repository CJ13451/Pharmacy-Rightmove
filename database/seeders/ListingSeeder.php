<?php

namespace Database\Seeders;

use App\Enums\ListingStatus;
use App\Enums\Region;
use App\Models\PropertyListing;
use App\Models\User;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        if (PropertyListing::query()->exists()) {
            $this->command?->info('Property listings already seeded, skipping.');
            return;
        }

        $agent = User::where('email', 'agent@pharmacyowner.co.uk')->first()
            ?? User::where('role', 'estate_agent')->first()
            ?? User::where('role', 'admin')->first();

        if (! $agent) {
            $this->command?->warn('No agent/admin user found, skipping ListingSeeder.');
            return;
        }

        $listings = [
            [
                'title' => 'High Street Pharmacy with 3-Bed Accommodation',
                'description' => 'Well-presented independent pharmacy occupying a prominent position on a busy high street, with self-contained 3-bedroom owner\'s accommodation above. Strong NHS contract, loyal patient base and consistently growing items.',
                'price' => 875_000_00,
                'town' => 'Kensington',
                'county' => 'Greater London',
                'postcode' => 'W8 6NA',
                'region' => Region::LONDON,
                'property_type' => 'freehold',
                'has_accommodation' => true,
                'accommodation_details' => 'Self-contained 3-bedroom flat above the pharmacy, accessed via private entrance.',
                'monthly_items' => 8500,
                'annual_turnover' => 1_450_000_00,
                'annual_gross_profit' => 365_000_00,
                'staff_count' => 6,
                'featured' => true,
            ],
            [
                'title' => 'Village Pharmacy with Strong NHS Contract',
                'description' => 'Sole pharmacy serving a thriving village community, co-located next to a busy GP surgery. Established repeat prescription business and highly regarded local reputation.',
                'price' => 425_000_00,
                'town' => 'Didsbury',
                'county' => 'Greater Manchester',
                'postcode' => 'M20 2UE',
                'region' => Region::NORTH_WEST,
                'property_type' => 'leasehold',
                'lease_years_remaining' => 14,
                'rent_per_annum' => 28_000_00,
                'monthly_items' => 6200,
                'annual_turnover' => 985_000_00,
                'annual_gross_profit' => 232_000_00,
                'staff_count' => 4,
                'featured' => true,
            ],
            [
                'title' => 'Medical Centre Pharmacy, Multi-Site Group',
                'description' => 'Modern pharmacy unit integrated within a purpose-built medical centre. Part of a three-branch group being offered as a single sale with experienced management team in place.',
                'price' => 1_250_000_00,
                'town' => 'Clifton',
                'county' => 'Bristol',
                'postcode' => 'BS8 2ES',
                'region' => Region::SOUTH_WEST,
                'property_type' => 'freehold',
                'monthly_items' => 12400,
                'annual_turnover' => 2_100_000_00,
                'annual_gross_profit' => 510_000_00,
                'staff_count' => 9,
                'featured' => true,
            ],
            [
                'title' => 'Shopping Centre Unit, High Footfall',
                'description' => 'Well-fitted pharmacy unit within a busy regional shopping centre. Balanced mix of NHS dispensing and strong front-of-shop retail with an established beauty counter.',
                'price' => 320_000_00,
                'town' => 'Birmingham',
                'county' => 'West Midlands',
                'postcode' => 'B2 4QA',
                'region' => Region::WEST_MIDLANDS,
                'property_type' => 'leasehold',
                'lease_years_remaining' => 9,
                'rent_per_annum' => 42_000_00,
                'monthly_items' => 5800,
                'annual_turnover' => 890_000_00,
                'annual_gross_profit' => 205_000_00,
                'staff_count' => 4,
                'featured' => true,
            ],
            [
                'title' => 'Rural Pharmacy with Dispensing Doctor Partnership',
                'description' => 'Charming rural pharmacy in a picturesque market town, with a long-standing relationship with the neighbouring dispensing practice. Low staff turnover and excellent retention.',
                'price' => 545_000_00,
                'town' => 'Ludlow',
                'county' => 'Shropshire',
                'postcode' => 'SY8 1AA',
                'region' => Region::WEST_MIDLANDS,
                'property_type' => 'freehold',
                'has_accommodation' => true,
                'monthly_items' => 5200,
                'annual_turnover' => 820_000_00,
                'annual_gross_profit' => 198_000_00,
                'staff_count' => 3,
            ],
            [
                'title' => 'Health Centre Pharmacy, Strong MUR Income',
                'description' => 'Recently refurbished pharmacy situated inside an NHS health centre, serving a patient list of over 14,000. Excellent service income and an experienced clinical pharmacist in post.',
                'price' => 695_000_00,
                'town' => 'Leeds',
                'county' => 'West Yorkshire',
                'postcode' => 'LS2 9HD',
                'region' => Region::YORKSHIRE,
                'property_type' => 'leasehold',
                'lease_years_remaining' => 18,
                'rent_per_annum' => 36_000_00,
                'monthly_items' => 7800,
                'annual_turnover' => 1_240_000_00,
                'annual_gross_profit' => 296_000_00,
                'staff_count' => 6,
            ],
            [
                'title' => 'Independent Pharmacy Group (2 Branches)',
                'description' => 'Two-branch independent pharmacy group offered as a single sale. Both branches are profitable, well-staffed and supported by strong back-office infrastructure.',
                'price' => 1_650_000_00,
                'town' => 'Edinburgh',
                'county' => 'Midlothian',
                'postcode' => 'EH3 9PG',
                'region' => Region::SCOTLAND,
                'property_type' => 'leasehold',
                'lease_years_remaining' => 12,
                'rent_per_annum' => 72_000_00,
                'monthly_items' => 15200,
                'annual_turnover' => 2_640_000_00,
                'annual_gross_profit' => 612_000_00,
                'staff_count' => 11,
            ],
            [
                'title' => 'Suburban Pharmacy, Excellent Parking',
                'description' => 'Popular suburban pharmacy with generous on-site parking, occupying a standalone unit in a well-served residential neighbourhood. Strong delivery service and repeat prescription base.',
                'price' => 385_000_00,
                'town' => 'Cardiff',
                'county' => 'South Glamorgan',
                'postcode' => 'CF14 5GJ',
                'region' => Region::WALES,
                'property_type' => 'leasehold',
                'lease_years_remaining' => 15,
                'rent_per_annum' => 24_000_00,
                'monthly_items' => 5600,
                'annual_turnover' => 860_000_00,
                'annual_gross_profit' => 198_000_00,
                'staff_count' => 4,
            ],
            [
                'title' => 'City Centre Pharmacy, Corporate Client Base',
                'description' => 'Well-established pharmacy in the heart of the business district with a strong corporate health and travel clinic income. Great opportunity for an operator wanting a services-led business.',
                'price' => 560_000_00,
                'town' => 'Newcastle upon Tyne',
                'county' => 'Tyne and Wear',
                'postcode' => 'NE1 6UP',
                'region' => Region::NORTH_EAST,
                'property_type' => 'leasehold',
                'lease_years_remaining' => 10,
                'rent_per_annum' => 33_000_00,
                'monthly_items' => 4900,
                'annual_turnover' => 1_020_000_00,
                'annual_gross_profit' => 248_000_00,
                'staff_count' => 5,
            ],
            [
                'title' => 'Coastal Pharmacy, Freehold with 2-Bed Flat',
                'description' => 'Sole pharmacy serving a popular seaside town, offered with the freehold and a 2-bedroom flat above. Steady year-round trading with seasonal uplift in summer.',
                'price' => 475_000_00,
                'town' => 'Whitstable',
                'county' => 'Kent',
                'postcode' => 'CT5 1BB',
                'region' => Region::SOUTH_EAST,
                'property_type' => 'freehold',
                'has_accommodation' => true,
                'monthly_items' => 4600,
                'annual_turnover' => 770_000_00,
                'annual_gross_profit' => 186_000_00,
                'staff_count' => 3,
            ],
            [
                'title' => 'Under Offer — Market Town Pharmacy',
                'description' => 'Attractive market town pharmacy with a loyal customer base. Currently under offer — register your interest to be notified of similar opportunities.',
                'price' => 410_000_00,
                'town' => 'Shrewsbury',
                'county' => 'Shropshire',
                'postcode' => 'SY1 1XE',
                'region' => Region::WEST_MIDLANDS,
                'property_type' => 'leasehold',
                'lease_years_remaining' => 11,
                'rent_per_annum' => 22_000_00,
                'monthly_items' => 5400,
                'annual_turnover' => 820_000_00,
                'annual_gross_profit' => 195_000_00,
                'staff_count' => 4,
                'status_override' => ListingStatus::UNDER_OFFER,
            ],
            [
                'title' => 'New to Market — Modern Health Hub Pharmacy',
                'description' => 'Brand new to market: modern pharmacy inside a purpose-built NHS health hub. Exceptional service income and an experienced team already in place.',
                'price' => 920_000_00,
                'town' => 'Nottingham',
                'county' => 'Nottinghamshire',
                'postcode' => 'NG1 5FS',
                'region' => Region::EAST_MIDLANDS,
                'property_type' => 'leasehold',
                'lease_years_remaining' => 20,
                'rent_per_annum' => 48_000_00,
                'monthly_items' => 9400,
                'annual_turnover' => 1_680_000_00,
                'annual_gross_profit' => 398_000_00,
                'staff_count' => 8,
            ],
        ];

        foreach ($listings as $listing) {
            $status = $listing['status_override'] ?? ListingStatus::ACTIVE;
            unset($listing['status_override']);

            PropertyListing::create(array_merge([
                'status' => $status,
                'payment_status' => 'paid',
                'paid_at' => now()->subDays(random_int(3, 60)),
                'expires_at' => now()->addMonths(3),
                'listing_tier' => $listing['featured'] ?? false ? 'featured' : 'standard',
                'price_qualifier' => 'asking',
                'address_line_1' => explode(',', $listing['title'])[0],
                'nhs_contract' => true,
                'services' => ['nhs_dispensing', 'mur', 'flu_vaccination'],
                'user_id' => $agent->id,
                'agent_name' => $agent->full_name ?? 'P3 Listings Team',
                'agent_company' => 'Pharmacy Owner by P3 Brokers',
                'agent_email' => $agent->email,
                'agent_phone' => '020 7946 0800',
                'views_count' => random_int(40, 1800),
                'enquiries_count' => random_int(0, 25),
                'saves_count' => random_int(0, 40),
                'published_at' => now()->subDays(random_int(1, 60)),
                'featured' => $listing['featured'] ?? false,
            ], $listing));
        }

        $this->command?->info('Seeded '.count($listings).' property listings.');
    }
}
