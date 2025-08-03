<?php

namespace App\Livewire\LegalStatus;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\LegalStatus as LegalStatusForm;
use Flux\Flux;

#[Title('Edit Legal Status')]
class Edit extends Component
{
    public LegalStatusForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.legal-status.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('legal-statuses.index');
    }
    public function cancel()
    {
        return redirect()->route('legal-statuses.index');
    }
}
