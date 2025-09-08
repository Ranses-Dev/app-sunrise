<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection as SupportCollection;

class UserRepository implements UserRepositoryInterface
{
    public function totalUsers(): int
    {
        return User::count();
    }

    public function getAllUsers(): Collection
    {
        return User::all();
    }
    public function findById(int $id): ?User
    {
        return User::findOrFail($id);
    }

    public function getClientsActiveByUser(): array
    {
        return  DB::table('users')
            ->join('contract_meals', 'users.id', '=', 'contract_meals.client_service_specialist_id')
            ->where('contract_meals.is_active', true)
            ->groupBy('users.id', 'users.name')
            ->select('users.name', DB::raw('COUNT(contract_meals.id) as total'))
            ->get()
            ->toArray();
    }
    public function getCertificationsOverdue(): QueryBuilder
    {
        return DB::table('users')
            ->join('contract_meals', 'users.id', '=', 'contract_meals.client_service_specialist_id')
            ->where('contract_meals.is_active', true)
            ->where('contract_meals.recertification_date', '<', now())
            ->groupBy('users.id')
            ->select('users.id', 'users.name', DB::raw('COUNT(contract_meals.id) as total'))
            ->orderBy('total', 'desc');
    }
    public function getCertificationsDue(): QueryBuilder
    {
        $today = now();
        $lastDay = $today->copy()->addMonths(3);
        return DB::table('users')
            ->join('contract_meals', 'users.id', '=', 'contract_meals.client_service_specialist_id')
            ->where('contract_meals.is_active', true)
            ->whereBetween('contract_meals.recertification_date', [$today, $lastDay])
            ->groupBy('users.id')
            ->select('users.id', 'users.name', DB::raw('COUNT(contract_meals.id) as total'))
            ->orderBy('total', 'desc');
    }

    public function getInformationBySpecialists(): Builder
    {
        return User::withCount(['contractMeals as count_contract_meals', 'contractHowpas as count_contract_howpas', 'inspections as count_inspections'])->addSelect([
            'total_contracts' => function ($query) {
                $query->selectRaw(
                    '(select count(*) from contract_meals where contract_meals.client_service_specialist_id = users.id) +
                 (select count(*) from howpa_contracts where howpa_contracts.client_service_specialist_id = users.id) +
                 (select count(*) from inspections where inspections.housing_inspector_id = users.id)'
                );
            }
        ])
            ->orderByDesc('total_contracts');
    }
}
