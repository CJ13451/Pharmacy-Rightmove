<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'email' => 'admin@p3pharmacy.co.uk',
            'password' => Hash::make('password'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'job_title' => 'other',
            'currently_own_pharmacy' => false,
            'looking_to_buy' => false,
            'role' => UserRole::ADMIN,
            'newsletter_subscribed' => false,
            'email_verified_at' => now(),
        ]);

        // Create editor user
        User::create([
            'email' => 'editor@p3pharmacy.co.uk',
            'password' => Hash::make('password'),
            'first_name' => 'Sarah',
            'last_name' => 'Editor',
            'job_title' => 'other',
            'currently_own_pharmacy' => false,
            'looking_to_buy' => false,
            'role' => UserRole::EDITOR,
            'newsletter_subscribed' => true,
            'email_verified_at' => now(),
        ]);

        // Create content editor user
        User::create([
            'email' => 'writer@p3pharmacy.co.uk',
            'password' => Hash::make('password'),
            'first_name' => 'James',
            'last_name' => 'Writer',
            'job_title' => 'other',
            'currently_own_pharmacy' => false,
            'looking_to_buy' => false,
            'role' => UserRole::CONTENT_EDITOR,
            'newsletter_subscribed' => true,
            'email_verified_at' => now(),
        ]);

        // Create estate agent user
        User::create([
            'email' => 'agent@p3pharmacy.co.uk',
            'password' => Hash::make('password'),
            'first_name' => 'David',
            'last_name' => 'Agent',
            'job_title' => 'estate_agent',
            'currently_own_pharmacy' => false,
            'looking_to_buy' => false,
            'role' => UserRole::ESTATE_AGENT,
            'newsletter_subscribed' => true,
            'email_verified_at' => now(),
        ]);

        // Create pharmacist user (looking to buy)
        User::create([
            'email' => 'pharmacist@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'John',
            'last_name' => 'Smith',
            'job_title' => 'pharmacist',
            'gphc_number' => '2012345',
            'currently_own_pharmacy' => false,
            'looking_to_buy' => true,
            'buy_location_preference' => 'London, South East',
            'buy_timeframe' => 'within_6_months',
            'role' => UserRole::REGISTERED_USER,
            'newsletter_subscribed' => true,
            'email_verified_at' => now(),
        ]);

        // Create pharmacy owner user
        User::create([
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Emma',
            'last_name' => 'Owner',
            'job_title' => 'pharmacy_owner',
            'gphc_number' => '2098765',
            'currently_own_pharmacy' => true,
            'number_of_pharmacies' => 2,
            'current_workplace' => 'Smith\'s Pharmacy, London',
            'looking_to_buy' => true,
            'buy_location_preference' => 'Anywhere UK',
            'buy_timeframe' => 'actively_looking',
            'role' => UserRole::REGISTERED_USER,
            'newsletter_subscribed' => true,
            'email_verified_at' => now(),
        ]);

        // Create supplier user (free tier)
        User::create([
            'email' => 'supplier@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Mike',
            'last_name' => 'Supplier',
            'job_title' => 'supplier_vendor',
            'currently_own_pharmacy' => false,
            'looking_to_buy' => false,
            'role' => UserRole::SUPPLIER_FREE,
            'newsletter_subscribed' => true,
            'email_verified_at' => now(),
        ]);

        $this->command->info('Created test users:');
        $this->command->table(
            ['Email', 'Password', 'Role'],
            [
                ['admin@p3pharmacy.co.uk', 'password', 'Admin'],
                ['editor@p3pharmacy.co.uk', 'password', 'Editor'],
                ['writer@p3pharmacy.co.uk', 'password', 'Content Editor'],
                ['agent@p3pharmacy.co.uk', 'password', 'Estate Agent'],
                ['pharmacist@example.com', 'password', 'Registered User (Pharmacist)'],
                ['owner@example.com', 'password', 'Registered User (Owner)'],
                ['supplier@example.com', 'password', 'Supplier (Free)'],
            ]
        );
    }
}
