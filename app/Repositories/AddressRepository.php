<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class AddressRepository implements AddressRepositoryInterface
{
    public function getAll(): Collection
    {
        return Address::all();
    }

    public function getFiltered(array $filters): Builder
    {
        return Address::search($filters);
    }

    public function getCitiesRegistered(): Collection
    {
        return Address::select('city')->distinct()->get();
    }

    public function getStatesRegistered(): Collection
    {
        return Address::select('state_abbreviation')->distinct()->get();
    }

    public function getCountiesRegistered(): Collection
    {
        return Address::select('county_name')->distinct()->get();
    }

    public function findById(int $id): ?Address
    {
        return Address::find($id);
    }
    public function create(array $data): Address
    {
        return Address::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $address = $this->findById($id);
        if ($address) {
            return $address->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $address = $this->findById($id);
        if ($address) {
            return $address->delete();
        }
        return false;
    }
    public function addressExists(array $data, int|null $id = null): bool
    {

        return  Address::query()
            ->search($data)
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })->exists();
    }
}
