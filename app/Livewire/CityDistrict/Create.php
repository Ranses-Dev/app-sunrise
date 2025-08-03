<?php

namespace App\Livewire\CityDistrict;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\CityDistrict as CityDistrictForm;
use Flux\Flux;

#[Title('Create City District')]
class Create extends Component
{
    public CityDistrictForm $form;
    public function render()
    {
        return view('livewire.city-district.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('city-districts.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('city-districts.index');
    }
}
