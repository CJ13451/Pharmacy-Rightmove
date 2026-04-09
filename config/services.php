<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    */
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        
        // Listing pricing (in pence)
        'listing_prices' => [
            'standard' => env('STRIPE_LISTING_STANDARD_PRICE', 29900), // £299
            'featured' => env('STRIPE_LISTING_FEATURED_PRICE', 49900), // £499
            'premium' => env('STRIPE_LISTING_PREMIUM_PRICE', 79900),  // £799
        ],
        
        // Supplier subscription Stripe Price IDs
        'supplier_prices' => [
            'premium' => [
                'month' => env('STRIPE_SUPPLIER_PREMIUM_MONTHLY'),
                'year' => env('STRIPE_SUPPLIER_PREMIUM_YEARLY'),
            ],
            'featured' => [
                'month' => env('STRIPE_SUPPLIER_FEATURED_MONTHLY'),
                'year' => env('STRIPE_SUPPLIER_FEATURED_YEARLY'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dotdigital Configuration
    |--------------------------------------------------------------------------
    */
    'dotdigital' => [
        'base_url' => env('DOTDIGITAL_BASE_URL', 'https://r1-api.dotdigital.com'),
        'username' => env('DOTDIGITAL_USERNAME'),
        'password' => env('DOTDIGITAL_PASSWORD'),
        
        // Address Book IDs
        'address_books' => [
            'newsletter' => env('DOTDIGITAL_ADDRESSBOOK_NEWSLETTER'),
            'buyers' => env('DOTDIGITAL_ADDRESSBOOK_BUYERS'),
            'agents' => env('DOTDIGITAL_ADDRESSBOOK_AGENTS'),
            'suppliers' => env('DOTDIGITAL_ADDRESSBOOK_SUPPLIERS'),
        ],
        
        // Campaign IDs
        'campaigns' => [
            'welcome' => env('DOTDIGITAL_CAMPAIGN_WELCOME'),
            'email_verification' => env('DOTDIGITAL_CAMPAIGN_EMAIL_VERIFICATION'),
            'password_reset' => env('DOTDIGITAL_CAMPAIGN_PASSWORD_RESET'),
            'new_listing_alert' => env('DOTDIGITAL_CAMPAIGN_NEW_LISTING_ALERT'),
            'enquiry_received' => env('DOTDIGITAL_CAMPAIGN_ENQUIRY_RECEIVED'),
            'enquiry_confirmation' => env('DOTDIGITAL_CAMPAIGN_ENQUIRY_CONFIRMATION'),
            'course_purchase' => env('DOTDIGITAL_CAMPAIGN_COURSE_PURCHASE'),
            'course_completion' => env('DOTDIGITAL_CAMPAIGN_COURSE_COMPLETION'),
            'listing_published' => env('DOTDIGITAL_CAMPAIGN_LISTING_PUBLISHED'),
            'listing_expiring' => env('DOTDIGITAL_CAMPAIGN_LISTING_EXPIRING'),
            'subscription_welcome' => env('DOTDIGITAL_CAMPAIGN_SUBSCRIPTION_WELCOME'),
            'subscription_renewal' => env('DOTDIGITAL_CAMPAIGN_SUBSCRIPTION_RENEWAL'),
            'subscription_cancelled' => env('DOTDIGITAL_CAMPAIGN_SUBSCRIPTION_CANCELLED'),
            'payment_failed' => env('DOTDIGITAL_CAMPAIGN_PAYMENT_FAILED'),
            'weekly_newsletter' => env('DOTDIGITAL_CAMPAIGN_WEEKLY_NEWSLETTER'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Maps API
    |--------------------------------------------------------------------------
    */
    'google' => [
        'maps_key' => env('GOOGLE_MAPS_API_KEY'),
    ],

];
