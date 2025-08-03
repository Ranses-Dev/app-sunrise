<?php

namespace App\Livewire\MonthlyAssistancePayment;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\MonthlyAssistancePayment as MonthlyAssistancePaymentForm;
use Flux\Flux;

#[Title('Edit Monthly Assistance Payment')]
class Edit extends Component
{
    public MonthlyAssistancePaymentForm $form;

    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.monthly-assistance-payment.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('monthly-assistance-payments.index');
    }

    public function cancel()
    {
        return redirect()->route('monthly-assistance-payments.index');
    }
}
