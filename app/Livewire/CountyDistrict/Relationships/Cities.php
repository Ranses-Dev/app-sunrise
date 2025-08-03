<?php

namespace App\Livewire\CountyDistrict\Relationships;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\CountyDistrict as CountyDistrictForm;
use App\Models\City;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;

class Cities extends Component
{
    use WithPagination, WithoutUrlPagination;
    public int $districtId;
    public bool $showModalCity = false;
    public int $cityId;
    public CountyDistrictForm $form;
    public function mount($id)
    {
        $this->districtId = $id;
    }
    public function render()
    {
        return view('livewire.county-district.relationships.cities');
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return City::whereHas('districts', function ($query) {
            $query->where('county_district_id', $this->districtId);
        })->paginate(pageName: 'cities-page');
    }
    #[Computed]
    public function unlinkCities(): Collection
    {
        return  $this->form->unlinkCities($this->districtId);
    }
    public function linkCity()
    {
        $this->validate(
            [
                'cityId' => 'required|exists:cities,id',
            ],
            [
                'cityId.required' => 'Please select a city.',
                'cityId.exists' => 'The selected city does not exist.',
            ]
        );
        $this->form->linkCity($this->districtId, $this->cityId);
        Flux::toast(position: 'top right', text: 'Your changes have been saved.', variant: 'success');
        $this->hideModal();
    }
    public function unlinkCity(int $cityId)
    {
        $this->form->unlinkCity($this->districtId, $cityId);
        Flux::toast(position: 'top right', text: 'Your changes have been saved.', variant: 'success');
        $this->hideModal();
    }
    public function showModal()
    {
        $this->showModalCity = true;
    }
    public function hideModal()
    {
        $this->showModalCity = false;
        $this->resetValidation();
        $this->reset(['cityId', 'showModalCity']);
    }
}
