<?php

namespace App\Livewire\CountyDistrict;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\CountyDistrict as CountyDistrictForm;
use Flux\Flux;

#[Title('Edit County District')]
class Edit extends Component
{
    public CountyDistrictForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.county-district.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('county-districts.index');
    }
    public function cancel()
    {
        return redirect()->route('county-districts.index');
    }
}
