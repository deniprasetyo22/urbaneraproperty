<?php

namespace App\Filament\Widgets;

use App\Models\Bank;
use App\Models\Article;
use App\Models\Message;
use App\Models\Brochure;
use App\Models\Property;
use App\Models\Residence;
use App\Models\Testimonial;
use App\Models\CustomerData;
use App\Models\CompanyProfile;
use App\Models\CustomerFeedback;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Articles', Article::count())
                ->icon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Banks', Bank::count())
                ->icon('heroicon-o-building-library')
                ->color('info'),

            Stat::make('Brochures', Brochure::count())
                ->icon('heroicon-o-book-open')
                ->color('warning'),

            Stat::make('Company Profiles', CompanyProfile::count())
                ->icon('heroicon-o-building-office-2')
                ->color('gray'),

            Stat::make('Customer Data', CustomerData::count())
                ->icon('heroicon-o-document-chart-bar')
                ->color('success'),

            Stat::make('Customer Feedbacks', CustomerFeedback::count())
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('success'),

            Stat::make('Customer Messages', Message::count())
                ->icon('heroicon-o-envelope')
                ->color('danger'),

            Stat::make('Properties', Property::count())
                ->icon('heroicon-o-home-modern')
                ->color('primary'),

            Stat::make('Residences', Residence::count())
                ->icon('heroicon-o-building-office')
                ->color('info'),

            Stat::make('Testimonials', Testimonial::count())
                ->icon('heroicon-o-hand-thumb-up')
                ->color('warning'),
        ];
    }
}