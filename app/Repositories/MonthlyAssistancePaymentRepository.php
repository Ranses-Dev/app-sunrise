<?php

namespace App\Repositories;

use App\Models\MonthlyAssistancePayment;
use Illuminate\Database\Eloquent\Collection;


class MonthlyAssistancePaymentRepository implements MonthlyAssistancePaymentRepositoryInterface
{
    public function getAll(): Collection
    {
        return MonthlyAssistancePayment::all();
    }
    public function findById(int $id): ?MonthlyAssistancePayment
    {
        return MonthlyAssistancePayment::find($id);
    }
    public function create(array $data): MonthlyAssistancePayment
    {
        return MonthlyAssistancePayment::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $identificationType = $this->findById($id);
        if ($identificationType) {
            return $identificationType->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $identificationType = $this->findById($id);
        if ($identificationType) {
            return $identificationType->delete();
        }
        return false;
    }
}
