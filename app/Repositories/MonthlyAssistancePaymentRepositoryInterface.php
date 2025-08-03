<?php

namespace App\Repositories;


use App\Models\MonthlyAssistancePayment;
use Illuminate\Database\Eloquent\Collection;


interface MonthlyAssistancePaymentRepositoryInterface
{

    public function getAll(): Collection;

    public function findById(int $id): ?MonthlyAssistancePayment;

    public function create(array $data): MonthlyAssistancePayment;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}
