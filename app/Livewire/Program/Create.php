<?php

namespace App\Livewire\Program;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Program as ProgramForm;
use Flux\Flux;


#[Title('Create Program')]
class Create extends Component
{
    public ProgramForm $form;
    public function render()
    {
        return view('livewire.program.create');
    }
    public function store()
    {

        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('programs.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('programs.index');
    }
}
