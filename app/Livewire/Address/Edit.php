<?php

namespace App\Livewire\Address;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Address as AddressForm;
use Flux\Flux;

#[Title('Edit Address')]
class Edit extends Component
{
    public AddressForm $form;

    public function mount(int $id)
    {
        $this->form->setAddress($id);
    }

    public function render()
    {
        return view('livewire.address.edit');
    }

    public function cancel()
    {
        $this->redirect(route('addresses.index'), true);
    }

    public function save()
    {
        if ($this->form->save()) {
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
            return redirect()->route('addresses.index');
        }
    }
}
