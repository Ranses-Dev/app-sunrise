<?php

namespace App\Livewire\HowpaContract;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HowpaContract as FormsHowpaContract;
use Flux\Flux;

#[Title('Edit Howpa Contract')]
class Edit extends Component
{
    public FormsHowpaContract $form;

    public function mount(int|string $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.howpa-contract.edit');
    }

    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        $this->redirect(route('howpa.contracts.index'), true);
    }

    public function cancel()
    {
        $this->redirect(route('howpa.contracts.index'), true);
    }
}
