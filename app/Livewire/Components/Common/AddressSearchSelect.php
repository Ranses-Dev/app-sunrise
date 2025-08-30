<?php

namespace App\Livewire\Components\Common;

use Livewire\Component;
use App\Livewire\Forms\Address as AddressForm;

class AddressSearchSelect extends Component
{
    public AddressForm $form;
    public bool $showModal = false;
    public function render()
    {
        return view('livewire.components.common.address-search-select');
    }

    public function handleShowModal()
    {
        $this->showModal = true;
        $this->loadFilters();
    }

    public function handleCloseModal()
    {
        $this->showModal = false;
    }

    public function selectAddress(int $id)
    {
        $this->dispatch('selected', addressId:$id);
        $this->form->reset();
        $this->handleCloseModal();
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
