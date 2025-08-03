<?php

namespace App\Livewire\HouseholdRelationType;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HouseholdRelationType as HouseholdRelationTypeForm;
use Flux\Flux;

#[Title('Edit Household Relation Type')]
class Edit extends Component
{
    public HouseholdRelationTypeForm $form;
    public function mount(int $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.household-relation-type.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('household-relation-types.index');
    }
    public function cancel()
    {
        return redirect()->route('household-relation-types.index');
    }
}
