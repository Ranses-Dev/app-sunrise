<?php

namespace App\Livewire\Gender;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Gender as GenderForm;
use Flux\Flux;

#[Title('Create Gender')]
class Create extends Component
{
    public GenderForm $form;
    public function render()
    {
        return view('livewire.gender.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('genders.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('genders.index');
    }
}
