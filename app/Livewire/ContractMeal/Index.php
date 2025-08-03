<?php

namespace App\Livewire\ContractMeal;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\Livewire\Forms\ContractMeal as ContractMealForm;

#[Title('Contract Meals')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public ContractMealForm $form;

    public function render()
    {
        return view('livewire.contract-meal.index');
    }

    public function create()
    {
        return $this->redirect(route('contract-meals.create'), navigate: true);
    }
    public function edit(int $id)
    {
        return $this->redirect(route('contract-meals.edit', $id), navigate: true);
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
        return $this->form->getFiltered($this->search)->paginate(pageName: 'contract-meals-page');
    }
}
