<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\App;

class StatsOverview extends BaseWidget
{


    protected function getStats(): array
    {
        $clientRepository = App::make(ClientRepositoryInterface::class);
        $userRepository = App::make(UserRepositoryInterface::class);
        return [
            Stat::make('Users',  $userRepository->totalUsers()),
            Stat::make('Clients', $clientRepository->totalClients()),
            Stat::make('Upcoming Certifications', $clientRepository->totalCertificationsDue()),
            Stat::make('Overdue Certifications', $clientRepository->totalCertificationsOverdue()),
        ];
    }
}
