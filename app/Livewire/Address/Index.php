<?php

namespace App\Livewire\Address;

use App\Enums\CrudMessages;
use Livewire\Component;
use App\Livewire\Forms\Address as AddressForm;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('List Addresses')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public AddressForm $form;

    public function render()
    {
        return view('livewire.address.index');
    }

    public function mount()
    {
        $this->loadFilters();
    }
    public function create()
    {
        $this->redirect(route('addresses.create'), true);
    }
    public function edit(int $id)
    {
        $this->redirect(route('addresses.edit', $id), true);
    }
    public function show(int $id)
    {
        $this->redirect(route('addresses.show', $id), true);
    }

    public function delete($id)
    {
        $this->form->id = $id;
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
        if ($this->form->id) {
            $this->form->delete($this->form->id);
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->form->reset();
    }

    public function updatedFormFiltersCity()
    {
        $this->loadFilters();
    }
    public function updatedFormFiltersStateAbbreviation()
    {
        $this->loadFilters();
    }
    public function updatedFormFiltersCountyName()
    {
        $this->loadFilters();
    }
    public function updatedFormFiltersDeliveryLine1()
    {
        $this->loadFilters();
    }

    public function loadFilters()
    {
        $this->form->getCitiesRegistered();
        $this->form->getStatesRegistered();
        $this->form->getCountiesRegistered();
    }
}
