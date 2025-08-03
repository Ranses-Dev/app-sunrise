<?php

namespace App\Livewire\City;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\City as CityForm;
use Flux\Flux;

#[Title('Edit City')]
class Edit extends Component
{
    public CityForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.city.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('cities.index');
    }
    public function cancel()
    {
        return redirect()->route('cities.index');
    }
}
