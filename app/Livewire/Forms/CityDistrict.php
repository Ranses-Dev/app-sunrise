<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Repositories\CityDistrictRepositoryInterface;
use Illuminate\Validation\Rule;

class CityDistrict extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    protected CityDistrictRepositoryInterface $cityDistrictRepository;

    public function boot(CityDistrictRepositoryInterface $cityDistrictRepository)
    {
        $this->cityDistrictRepository = $cityDistrictRepository;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('city_districts')->ignore($this->id)],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->cityDistrictRepository->findById($id);
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
            $this->cityDistrictRepository->update($this->id, $data);
        } else {
            $this->cityDistrictRepository->create($data);
        }
        $this->reset(['id', 'name']);
    }

    public function delete()
    {
        if ($this->id) {
            $this->cityDistrictRepository->delete($this->id);
        }
    }
}
