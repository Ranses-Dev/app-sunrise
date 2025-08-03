<?php

namespace App\Livewire\HouseholdRelationType;

use App\Enums\CrudMessages;
use Livewire\Component;
use App\Livewire\Forms\HouseholdRelationType as HouseholdRelationTypeForm;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Household Relation Types')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public HouseholdRelationTypeForm $form;
    public function render()
    {
        return view('livewire.household-relation-type.index');
    }
    public function create()
    {
        return redirect()->route('household-relation-types.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('household-relation-types.edit', $id);
    }
    public function delete($id)
    {
        $this->idToDelete = $id;
        $this->dispatch('open-modal-delete');
    }
    #[On('cancel-delete')]
    public function cancelDelete()
    {
        $this->reset('idToDelete');
    }
    #[On('confirm-delete')]
    public function confirmDelete()
    {
        if ($this->idToDelete) {
            $this->form->id = $this->idToDelete;
            $this->form->delete();
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->reset('idToDelete');
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->form->getFiltered($this->search);
    }
}
