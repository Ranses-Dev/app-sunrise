<?php

namespace App\Livewire\Client\Relationships;

use App\Enums\CrudMessages;
use Livewire\Component;
use App\Livewire\Forms\EmergencyContact as EmergencyContactForm;
use Flux\Flux;
use Livewire\Attributes\On;

class EmergencyContact extends Component
{
    public EmergencyContactForm $form;
    public bool $showModal = false;
    public function mount(int $clientId)
    {
        $this->form->clientId = $clientId;
    }
    public function render()
    {
        return view('livewire.client.relationships.emergency-contact');
    }

    public function openModal(int|null $id = null)
    {
        if ($id) {
            $this->form->setData($id);
        } else {
            $this->form->getRelationTypesProperty();
        }
        $this->showModal = true;
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->form->reset(['id', 'householdRelationTypeId', 'name', 'address', 'phoneNumber']);
    }
    public function save()
    {
        $action = $this->form->id;
        $this->form->save();
        if ($action) {
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        } else {
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
        }
        $this->closeModal();
    }
    public function edit($id)
    {
        $this->openModal($id);
    }

    public function delete($id)
    {
        $this->form->id = $id;
        $this->modal('confirm-delete-emergency-contact')->show();
    }
    public function cancelDelete()
    {
        $this->modal('confirm-delete-emergency-contact')->close();
    }
    #[On('confirm-delete')]
    public function confirmDelete()
    {
        if ($this->form->id) {
            $this->form->delete();
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->modal('confirm-delete-emergency-contact')->close();
    }
}
