<?php

namespace App\Livewire\HealthcareProviderPlan;

use App\Enums\CrudMessages;
use Livewire\Component;
use App\Livewire\Forms\HealthcareProviderPlan as HealthcareProviderPlanForm;
use Flux\Flux;
use Livewire\Attributes\Title;

#[Title('Edit Health Care Provider Plan')]
class Edit extends Component
{
    public HealthcareProviderPlanForm $form;

    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.healthcare-provider-plan.edit');
    }

    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('healthcare-provider-plans.index');
    }
    public function cancel()
    {
        return redirect()->route('healthcare-provider-plans.index');
    }
}
