<?php

namespace Database\Seeders;

use App\Enums\ArticleCategory;
use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        if (Article::query()->exists()) {
            $this->command?->info('Articles already seeded, skipping.');
            return;
        }

        $editor = User::where('email', 'editor@pharmacyowner.co.uk')->first()
            ?? User::where('role', 'editor')->first()
            ?? User::where('role', 'admin')->first();

        $writer = User::where('email', 'writer@pharmacyowner.co.uk')->first() ?? $editor;

        if (! $editor) {
            $this->command?->warn('No editor/admin user found, skipping ArticleSeeder.');
            return;
        }

        $articles = [
            [
                'title' => 'NHS funding settlement: Impact on pharmacy valuations and what buyers should expect in 2026-27',
                'excerpt' => 'The new NHS funding announcement has significant implications for pharmacy acquisition strategies. Our analysis covers valuation adjustments, regional variations and negotiation considerations for buyers currently in the market.',
                'type' => ArticleType::MARKET_REPORT,
                'category' => ArticleCategory::MARKET,
                'is_featured' => true,
                'published_at' => now()->subDays(1),
                'author_id' => $editor->id,
            ],
            [
                'title' => 'PSNC publishes updated negotiation position for 2026-27',
                'excerpt' => 'Community Pharmacy England has released its formal position ahead of next month\'s funding discussions. Key asks focus on baseline funding uplifts and a revised services framework.',
                'type' => ArticleType::NEWS,
                'category' => ArticleCategory::POLICY,
                'published_at' => now()->subDays(2),
                'author_id' => $writer->id,
            ],
            [
                'title' => 'Q1 2026: Transaction volumes down 12% amid funding uncertainty',
                'excerpt' => 'Our quarterly market report shows transaction volume easing in the first quarter, with buyers taking a wait-and-see approach while the funding picture settles.',
                'type' => ArticleType::MARKET_REPORT,
                'category' => ArticleCategory::MARKET,
                'published_at' => now()->subDays(5),
                'author_id' => $editor->id,
            ],
            [
                'title' => 'GPhC updates inspection framework: What new owners need to know',
                'excerpt' => 'The regulator has published a refreshed inspection framework with a stronger focus on governance and patient safety. New owners should review their SOPs against the updated criteria.',
                'type' => ArticleType::NEWS,
                'category' => ArticleCategory::REGULATION,
                'published_at' => now()->subDays(7),
                'author_id' => $writer->id,
            ],
            [
                'title' => 'Independent prescribing: The commercial opportunity for pharmacy owners',
                'excerpt' => 'Independent prescribing is reshaping the community pharmacy services mix. We break down the revenue models, training pathways and infrastructure requirements owners should be planning for now.',
                'type' => ArticleType::ANALYSIS,
                'category' => ArticleCategory::CLINICAL,
                'published_at' => now()->subDays(9),
                'author_id' => $editor->id,
            ],
            [
                'title' => 'Regional spotlight: Why North West pharmacies are outperforming the national average',
                'excerpt' => 'The North West has recorded the strongest trading performance in the last two quarters. We look at what\'s driving it and whether the trend is sustainable for acquirers.',
                'type' => ArticleType::ANALYSIS,
                'category' => ArticleCategory::MARKET,
                'published_at' => now()->subDays(11),
                'author_id' => $editor->id,
            ],
            [
                'title' => 'Multiples vs independents: How the buyer profile has shifted in 2026',
                'excerpt' => 'Independent buyers are re-entering the market after two years of multiples-led consolidation. We look at deal structures, financing and what this means for vendor expectations.',
                'type' => ArticleType::OPINION,
                'category' => ArticleCategory::OWNERSHIP,
                'published_at' => now()->subDays(14),
                'author_id' => $writer->id,
            ],
            [
                'title' => 'Pharmacy First: Twelve months on, what the data tells us',
                'excerpt' => 'One year after launch, Pharmacy First volumes continue to climb. We review what the numbers mean for income mix, staffing and patient flow.',
                'type' => ArticleType::ANALYSIS,
                'category' => ArticleCategory::CLINICAL,
                'published_at' => now()->subDays(17),
                'author_id' => $editor->id,
            ],
            [
                'title' => 'Technology stack: Choosing a PMR system for a multi-site operator',
                'excerpt' => 'A practical guide to evaluating PMR systems when you\'re running more than one branch. We score the main vendors on integration, reporting and total cost of ownership.',
                'type' => ArticleType::GUIDE,
                'category' => ArticleCategory::TECHNOLOGY,
                'published_at' => now()->subDays(21),
                'author_id' => $writer->id,
            ],
            [
                'title' => 'Hub and spoke dispensing: Legal framework finalised',
                'excerpt' => 'The long-awaited legislation enabling hub and spoke dispensing across different legal entities has been laid before Parliament. Here\'s what owners need to plan for.',
                'type' => ArticleType::NEWS,
                'category' => ArticleCategory::REGULATION,
                'published_at' => now()->subDays(24),
                'author_id' => $editor->id,
            ],
            [
                'title' => 'Vendor due diligence: Preparing your pharmacy for sale in 2026',
                'excerpt' => 'A step-by-step playbook for owners considering a sale in the next 12 months — from cleaning up management accounts to staff TUPE and lease negotiations.',
                'type' => ArticleType::GUIDE,
                'category' => ArticleCategory::BUSINESS,
                'published_at' => now()->subDays(28),
                'author_id' => $writer->id,
            ],
            [
                'title' => 'Margin compression: Five levers every owner should be pulling',
                'excerpt' => 'With category margins under continuing pressure, operational efficiency is no longer a nice-to-have. Five practical levers that are working for owner-operators today.',
                'type' => ArticleType::OPINION,
                'category' => ArticleCategory::BUSINESS,
                'published_at' => now()->subDays(32),
                'author_id' => $editor->id,
            ],
        ];

        foreach ($articles as $article) {
            Article::create(array_merge($article, [
                'status' => ArticleStatus::PUBLISHED,
                'content' => $this->demoContent($article['title'], $article['excerpt']),
                'content_format' => 'html',
                'is_premium' => false,
                'views_count' => random_int(120, 4800),
            ]));
        }

        $this->command?->info('Seeded '.count($articles).' articles.');
    }

    private function demoContent(string $title, string $excerpt): string
    {
        return <<<HTML
<p class="lead">{$excerpt}</p>
<p>This article is demonstration content generated by the sample data seeder so the page layouts have something realistic to render against. Replace it with editorial copy from the admin panel when the real content is ready.</p>
<h2>Why this matters</h2>
<p>Pharmacy owners and prospective buyers are navigating a market reshaped by funding changes, new clinical services and shifting buyer profiles. Getting ahead of each of these requires timely, well-sourced analysis — which is exactly what the news and insight section of the platform is designed to deliver.</p>
<h2>Key takeaways</h2>
<ul>
<li>Understand how the latest policy change affects your asking price or acquisition budget.</li>
<li>Benchmark your operational KPIs against the regional averages in our market reports.</li>
<li>Use the Resources area to find templates, checklists and calculators relevant to this topic.</li>
</ul>
<p><em>{$title} was published as part of Pharmacy Owner by P3's market intelligence coverage.</em></p>
HTML;
    }
}
