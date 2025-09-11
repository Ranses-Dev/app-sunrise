<?php

namespace App\Livewire\Client;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\Client as ClientForm;
use App\Models\Client;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;


#[Title('Clients')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public ClientForm $form;
    public function mount()
    {
        $this->form->getLegalStatuses();
        $this->form->getIdentificationTypes();
        $this->form->getEthnicities();
        $this->form->getHealthcareProviders();
        $this->form->getGenders();
        $this->form->getIncomeTypes();
        $this->form->getCityDistricts();
        $this->form->getCountyDistricts();
        $this->form->getColumnsDefault();
        $this->form->getColumnsOptions();
    }
    public function render()
    {
        return view('livewire.client.index');
    }


    public function create()
    {
        return $this->redirect(route('clients.create'), navigate: true);
    }
    public function edit(int $id)
    {
        return $this->redirect(route('clients.edit', $id), navigate: true);
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

    public function exportClientListPdf()
    {
        return $this->redirect(url: route('statistics.clients.pdfs.list', ["filters" => $this->form->filters,"columns" => $this->form->columnsSelected]), navigate: false);
    }

    public function show(int $id)
    {
        return $this->redirect(route('clients.show', $id), navigate: true);
    }
    public function updatedFormFiltersCountyDistrictId()
    {

        $this->form->reset('filters.city_id');
        $this->form->getCitiesFiltered();
    }
    #[On('columns-updated')]
    public function updateColumns(array $columnsSelected)
    {
        $this->form->columnsSelected = $columnsSelected;
    }

    #[On('reset-filters')]
    public function resetFilters()
    {
        $this->form->resetFilters();
        $this->form->getLegalStatuses();
        $this->form->getIdentificationTypes();
        $this->form->getEthnicities();
        $this->form->getHealthcareProviders();
        $this->form->getGenders();
        $this->form->getIncomeTypes();
        $this->form->getCityDistricts();
        $this->form->getCountyDistricts();
    }

    public function exportExcel()
    {
        return $this->redirect(url: route('exports.excel.clients', ["filters" => $this->form->filters, "columns" => $this->form->columnsSelected]));
    }
}
