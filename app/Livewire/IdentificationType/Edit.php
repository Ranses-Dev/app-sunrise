<?php

namespace App\Livewire\IdentificationType;

use App\Enums\CrudMessages;
use App\Livewire\Forms\IdentificationType as IdentificationTypeForm;
use Flux\Flux;
use Livewire\Attributes\Title;
use Livewire\Component;
#[Title('Edit Identification Type')]
class Edit extends Component
{
    public IdentificationTypeForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.identification-type.edit');
    }
    public function update()
    {
        $this->form->update();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::UPDATE_SUCCESS->value);
        return redirect()->route('identification-types.index');
    }
    public function cancel()
    {
        return redirect()->route('identification-types.index');
    }
}
