<?php

namespace App\Livewire\Forms;

use App\Repositories\CityRepositoryInterface;
use Illuminate\Validation\Rule;
use Livewire\Form;

class City extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $districtId = null;
    protected CityRepositoryInterface $cityRepository;
    public function boot(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('cities')->ignore($this->id)],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->cityRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->name = $result->name;
                $this->districtId = $result->district_id;
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
            $this->cityRepository->update($this->id, $data);
        } else {
            $this->cityRepository->create($data);
        }
        $this->reset(['id', 'name']);
    }

    public function delete()
    {
        if ($this->id) {
            $this->cityRepository->delete($this->id);
        }
    }
}
