<?php

namespace App\Livewire\IncomeLimit;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\IncomeLimit as IncomeLimitForm;
use Flux\Flux;

#[Title('Income Limits')]
class Create extends Component
{
    public IncomeLimitForm $form;
    public function render()
    {
        return view('livewire.income-limit.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
        return redirect()->route('income-limits.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
    }
    public function cancel()
    {
        return redirect()->route('income-limits.index');
    }
}
