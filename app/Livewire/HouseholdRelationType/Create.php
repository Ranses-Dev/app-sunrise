<?php

namespace App\Livewire\HouseholdRelationType;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HouseholdRelationType as HouseholdRelationTypeForm;
use Flux\Flux;

#[Title('Create Household Relation Type')]
class Create extends Component
{
    public HouseholdRelationTypeForm $form;
    public function render()
    {
        return view('livewire.household-relation-type.create');
    }

    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
        return redirect()->route('household-relation-types.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
    }
    public function cancel()
    {
        return redirect()->route('household-relation-types.index');
    }
}
