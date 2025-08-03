<?php

namespace App\Livewire\Ethnicity;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Ethnicity as EthnicityForm;
use Flux\Flux;

#[Title('Create Ethnicity')]
class Create extends Component
{
    public EthnicityForm $form;
    public function render()
    {
        return view('livewire.ethnicity.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('ethnicities.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('ethnicities.index');
    }

}
