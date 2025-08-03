<?php

namespace App\Livewire\Program;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Program as ProgramForm;
use Flux\Flux;

#[Title('Edit Program')]
class Edit extends Component
{
    public ProgramForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.program.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('programs.index');
    }

    public function cancel()
    {
        return redirect()->route('programs.index');
    }
}
