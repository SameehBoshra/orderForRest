<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Admin', User::count())
            ->descriptionIcon('heroicon-o-user',IconPosition::Before)
            ->description('Total number of Admin')
            ->chart([7, 30, 3, 40, 4, 60])
            ->color('info') ,

            Stat::make('Products', Product::count())
            ->descriptionIcon('heroicon-o-square-3-stack-3d',IconPosition::Before)
            ->description('Total number of products')
            ->chart([7, 15, 50, 3, 15, 70, 17])
            ->color('success'),

            Stat::make('Orders', Order::count())
            ->descriptionIcon('heroicon-o-inbox-arrow-down',IconPosition::Before)
            ->description('Total number of orders')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('primary'),

            Stat::make('Order Has Preparation ', Order::where('status','Preparation')->count())
            ->descriptionIcon('heroicon-o-users',IconPosition::Before)
            ->chart([2, 50, 10, 3, 60, 4, 17])
            ->color('info'),

            Stat::make('Order Has On the way  ', Order::where('status','On the way')->count())
            ->descriptionIcon('heroicon-o-users',IconPosition::Before)
            ->chart([2, 50, 10, 3, 60, 4, 17])
            ->color('info'),

            Stat::make('Order Has Delivered  ', Order::where('status','Delivered')->count())
            ->descriptionIcon('heroicon-o-users',IconPosition::Before)
            ->chart([90, 50, 10, 50, 60, 4, 17])
            ->color('success'),

            Stat::make('Order Has Cancelled  ', Order::where('status','Cancelled')->count())
            ->descriptionIcon('heroicon-o-users',IconPosition::Before)
            ->chart([90, 50, 10, 50, 60, 4, 17])
            ->color('warning'),

        ];
    }
}
