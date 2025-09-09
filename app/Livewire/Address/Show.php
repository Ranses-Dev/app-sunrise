<?php

namespace App\Livewire\Address;

use Livewire\Component;
use App\Livewire\Forms\Address as AddressForm;
use Livewire\Attributes\Title;

#[Title('Address Details')]
class Show extends Component
{
    public AddressForm $form;
    public function mount($id)
    {

        $this->form->setAddress($id);
    }

    public function render()
    {
        return view('livewire.address.show');
    }
    public function goBack()
    {
        $this->redirect(route('addresses.index'), true);
    }
}
