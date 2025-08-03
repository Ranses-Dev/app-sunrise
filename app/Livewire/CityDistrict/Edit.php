<?php

namespace App\Livewire\CityDistrict;

use App\Enums\CrudMessages;
use Livewire\Component;
use App\Livewire\Forms\CityDistrict as CityDistrictForm;
use Flux\Flux;
use Livewire\Attributes\Title;

#[Title('Edit City District')]
class Edit extends Component
{
    public CityDistrictForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.city-district.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('city-districts.index');
    }
    public function cancel()
    {
        return redirect()->route('city-districts.index');
    }
}
