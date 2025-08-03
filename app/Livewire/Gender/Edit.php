<?php

namespace App\Livewire\Gender;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Gender as GenderForm;
use Flux\Flux;
use App\Enums\CrudMessages;
#[Title('Edit Gender')]
class Edit extends Component
{
    public GenderForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.gender.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('genders.index');
    }
    public function cancel()
    {
        return redirect()->route('genders.index');
    }

}
