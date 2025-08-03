<?php

namespace App\Livewire\LegalStatus;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\LegalStatus as LegalStatusForm;
use Flux\Flux;

#[Title('Create Legal Status')]
class Create extends Component
{
    public LegalStatusForm $form;
    public function render()
    {
        return view('livewire.legal-status.create');
    }

    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
        return redirect()->route('legal-statuses.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
    }
    public function cancel()
    {
        return redirect()->route('legal-statuses.index');
    }
}
