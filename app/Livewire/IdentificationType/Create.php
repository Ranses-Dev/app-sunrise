<?php

namespace App\Livewire\IdentificationType;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\IdentificationType as IdentificationTypeForm;
use Flux\Flux;

#[Title('Create Identification Type')]
class Create extends Component
{
    public IdentificationTypeForm $form;
    public function render()
    {
        return view('livewire.identification-type.create');
    }
    public function store()
    {
        $this->form->store();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('identification-types.index');
    }
    public function storeAndNew()
    {
        $this->form->store();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);

    }
    public function cancel()
    {
        return redirect()->route('identification-types.index');

    }
}
