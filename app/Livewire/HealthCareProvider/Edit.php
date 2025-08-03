<?php

namespace App\Livewire\HealthCareProvider;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HealthCareProvider as HealthCareProviderForm;
use Flux\Flux;

#[Title('Edit Health Care Provider')]
class Edit extends Component
{
    public HealthCareProviderForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.health-care-provider.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('health-care-providers.index');
    }
    public function cancel()
    {
        return redirect()->route('health-care-providers.index');
    }
}

