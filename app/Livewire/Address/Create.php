<?php

namespace App\Livewire\Address;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Address as AddressForm;
use Flux\Flux;

#[Title('Create Address')]
class Create extends Component
{
    public AddressForm $form;
    public function render()
    {
        return view('livewire.address.create');
    }
    public function  store(): bool
    {
        if ($this->form->save()) {
            Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
            $this->form->reset();
            return true;
        }
        return false;
    }
    public function create()
    {
        if ($this->store()) {
            $this->redirect(route('addresses.index'), true);
        }
    }

    public function createAndNew()
    {
        $this->store();
    }
    public function cancel()
    {

        $this->redirect(route('addresses.index'), true);
    }
}
