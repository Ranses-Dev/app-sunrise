<?php

namespace App\Livewire\MonthlyAssistancePayment;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\MonthlyAssistancePayment as MonthlyAssistancePaymentForm;
use Flux\Flux;

#[Title('Create Monthly Assistance Payment')]
class Create extends Component
{
    public MonthlyAssistancePaymentForm $form;
    public function render()
    {
        return view('livewire.monthly-assistance-payment.create');
    }
    public function store()
    {

        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('monthly-assistance-payments.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('monthly-assistance-payments.index');
    }

}
