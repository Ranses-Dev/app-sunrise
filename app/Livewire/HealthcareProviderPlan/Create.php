<?php

namespace App\Livewire\HealthcareProviderPlan;

use App\Enums\CrudMessages;
use App\Livewire\Forms\HealthcareProviderPlan as HealthcareProviderPlanForm;
use Flux\Flux;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Create Health Care Provider Plan')]
class Create extends Component
{
    public HealthcareProviderPlanForm $form;
    public function render()
    {
        return view('livewire.healthcare-provider-plan.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('healthcare-provider-plans.index');
    }

    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('healthcare-provider-plans.index');
    }
}
