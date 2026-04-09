<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Course;
use App\Models\Enquiry;
use App\Models\PropertyListing;
use App\Models\Supplier;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([7, 3, 4, 5, 6, 3, 5, 8])
                ->color('success'),

            Stat::make('Active Listings', PropertyListing::active()->count())
                ->description('Pharmacies for sale')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->chart([3, 5, 2, 7, 4, 5, 6, 4])
                ->color('info'),

            Stat::make('New Enquiries', Enquiry::where('status', 'new')->count())
                ->description('Awaiting response')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),

            Stat::make('Published Articles', Article::published()->count())
                ->description('Live content')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
        ];
    }
}
