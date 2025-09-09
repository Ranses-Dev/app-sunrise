<?php

namespace App\Livewire\HowpaContract;

use App\Enums\CrudMessages;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\HowpaContract as FormsHowpaContract;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('List Howpa Contracts')]
class Index extends Component
{
    use WithoutUrlPagination, WithPagination;

    public FormsHowpaContract $form;
    public function render()
    {
        return view('livewire.howpa-contract.index');
    }

    public function mount()
    {
        $this->form->getProgramBranches();
        $this->form->getClientServiceSpecialists();
        $this->form->getCityDistricts();
        $this->form->getCountyDistricts();
    }

    public function create()
    {
        $this->redirect(route('howpa.contracts.create'), true);
    }

    public function edit(int $id)
    {
        $this->redirect(route('howpa.contracts.edit', $id), true);
    }

    public function delete($id)
    {
        $this->form->id = $id;
        $this->dispatch('open-modal-delete');
    }
    #[On('cancel-delete')]
    public function cancelDelete()
    {
        $this->form->reset('id');
    }
    #[On('confirm-delete')]
    public function confirmDelete()
    {
        if ($this->form->id) {
            $this->form->delete();
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->form->reset('id');
    }

    #[On('reset-filters')]
    public function resetFilters()
    {
        $this->form->reset('filters');
    }

    public function export()
    {
        $this->redirect(route('exports.howpa-contracts', ["filters" => $this->form->filters]));
    }

    public function show(int $id)
    {
        $this->redirect(route('howpa.contracts.show', $id), true);
    }
    public function updatedFormFiltersCountyDistrictId()
    {
        $this->form->reset('filters.cityId');
        $this->form->getCitiesFilter();
    }
}
