<?php

namespace App\Livewire\CountyDistrict;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\CountyDistrict as CountyDistrictForm;
use Flux\Flux;

#[Title('Create County District')]
class Create extends Component
{
    public CountyDistrictForm $form;
    public function render()
    {
        return view('livewire.county-district.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('county-districts.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('county-districts.index');
    }
}
