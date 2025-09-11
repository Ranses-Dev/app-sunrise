<?php

namespace App\Livewire\Inspection;

use App\Enums\CrudMessages;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\Inspection as InspectionForm;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('Inspections')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public InspectionForm $form;
    public function render()
    {
        return view('livewire.inspection.index');
    }

    public function create()
    {
        $this->redirect(route('inspections.create'));
    }
    public function mount()
    {
        $this->form->getProgramBranches();
        $this->form->getHousingTypes();
        $this->form->getStatuses();
        $this->form->getUsers();
        $this->form->getColumnsDefault();
        $this->form->getColumnsOptions();
    }

    public function delete($id)
    {
        $this->form->id = $id;
        $this->dispatch('open-modal-delete');
    }

    #[On('confirm-delete')]
    public function confirmDelete()
    {
        if ($this->form->id) {
            $this->form->delete();
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->reset('form.id');
    }
    #[On('cancel-delete')]
    public function cancelDelete()
    {
        $this->form->reset('id');
    }

    #[On('reset-filters')]
    public function resetFilters()
    {
        $this->form->resetFilters();
    }

    public function edit(int $id)
    {
        $this->redirect(route('inspections.edit', ['id' => $id]), true);
    }

    public function export()
    {

        $this->redirect(route('exports.inspections', ["filters"=>$this->form->filters,"columns"=>$this->form->columnsSelected]));
    }

    public function exportExcel()
    {
        $this->redirect(route('exports.excel.inspections', ["filters"=>$this->form->filters,"columns"=>$this->form->columnsSelected]));
    }

    public function show(int $id)
    {
        $this->redirect(route('inspections.show', ['id' => $id]), true);
    }
    #[On('columns-updated')]
    public function updateColumns(array $columnsSelected)
    {
        $this->form->columnsSelected = $columnsSelected;
    }
}
