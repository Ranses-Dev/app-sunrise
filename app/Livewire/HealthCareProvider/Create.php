<?php

namespace App\Livewire\HealthCareProvider;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HealthCareProvider as HealthCareProviderForm;
use Flux\Flux;

#[Title('Create Health Care Provider')]
class Create extends Component
{
    public HealthCareProviderForm $form;
    public function render()
    {
        return view('livewire.health-care-provider.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('health-care-providers.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('health-care-providers.index');
    }
}
