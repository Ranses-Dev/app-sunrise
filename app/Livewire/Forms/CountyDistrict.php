<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Repositories\CountyDistrictRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;

class CountyDistrict extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    protected CountyDistrictRepositoryInterface $countyDistrictRepository;

    public function boot(CountyDistrictRepositoryInterface $countyDistrictRepository)
    {
        $this->countyDistrictRepository = $countyDistrictRepository;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('county_districts')->ignore($this->id)],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->countyDistrictRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->name = $result->name;
            }
        }
    }

    public function save()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
        ];
        if ($this->id) {
            $this->countyDistrictRepository->update($this->id, $data);
        } else {
            $this->countyDistrictRepository->create($data);
        }
        $this->reset(['id', 'name']);
    }

    public function delete()
    {
        if ($this->id) {
            $this->countyDistrictRepository->delete($this->id);
        }
    }

    public function unlinkCities(int $id): Collection
    {
        return $this->countyDistrictRepository->getUnlinkedCities($id);
    }

    public function linkCity(int $countyDistrictId, int $cityId): bool
    {
        return $this->countyDistrictRepository->linkCity($countyDistrictId, $cityId);
    }
    public function unlinkCity(int $countyDistrictId, int $cityId): bool
    {
        return $this->countyDistrictRepository->unlinkCity($countyDistrictId, $cityId);
    }
}
