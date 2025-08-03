<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface UserRepositoryInterface
{

    public function totalUsers(): int;
    public function getAllUsers(): Collection;
    public function findById(int $id): ?User;
    public function getClientsActiveByUser(): array;
    public function getCertificationsOverdue(): QueryBuilder;
    public function getCertificationsDue(): QueryBuilder;
}
