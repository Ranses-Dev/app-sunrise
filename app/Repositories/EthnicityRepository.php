<?php

namespace App\Repositories;

use App\Models\Ethnicity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EthnicityRepository implements EthnicityRepositoryInterface
{
    public function getAll(): Collection
    {
        return Ethnicity::all();
    }
    public function findById(int $id): ?Ethnicity
    {
        return Ethnicity::find($id);
    }
    public function create(array $data): Ethnicity
    {
        return Ethnicity::create($data);
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

    public function getEthnicitiesWithClientCount(): Builder
    {
        return     Ethnicity::query()
            ->withCount(['clients as count_clients'])
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM clients) AS total_clients'))
            ->addSelect(DB::raw(
                'ROUND(
            (
                (SELECT COUNT(*) FROM clients WHERE clients.ethnicity_id = ethnicities.id) * 100.0
                / NULLIF((SELECT COUNT(*) FROM clients), 0)
            ), 2
        ) AS percent'
            ))
            ->orderBy('count_clients', 'desc');
    }
}
