<?php

namespace App\Livewire\IncomeLimit;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\IncomeLimit as IncomeLimitForm;
use Flux\Flux;

#[Title('Edit Income Limit')]
class Edit extends Component
{
    public IncomeLimitForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.income-limit.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('income-limits.index');
    }
    public function cancel()
    {
        return redirect()->route('income-limits.index');
    }
}
