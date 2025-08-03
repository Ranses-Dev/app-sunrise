<?php

namespace App\Livewire\Ethnicity;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Ethnicity as EthnicityForm;
use Flux\Flux;

#[Title('Edit Ethnicity')]
class Edit extends Component
{
    public EthnicityForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.ethnicity.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('ethnicities.index');
    }
    public function cancel()
    {
        return redirect()->route('ethnicities.index');
    }
}
