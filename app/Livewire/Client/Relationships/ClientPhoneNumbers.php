<?php

namespace App\Livewire\Client\Relationships;

use App\Enums\CrudMessages;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\ClientPhoneNumber as ClientPhoneNumberForm;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class ClientPhoneNumbers extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public $showModal = false;
    public ClientPhoneNumberForm $clientPhoneNumberForm;
    public function mount(int $clientId)
    {
        $this->clientPhoneNumberForm->clientId = $clientId;
    }
    public function render()
    {
        return view('livewire.client.relationships.client-phone-numbers');
    }
    public function delete($id)
    {
        $this->idToDelete = $id;
        $this->modal('confirm-delete-phone-number')->show();
    }

    public function cancelDelete()
    {
        $this->reset('idToDelete');
        $this->modal('confirm-delete-phone-number')->close();
    }

    public function confirmDelete()
    {
        if ($this->idToDelete) {
            $this->clientPhoneNumberForm->id = $this->idToDelete;
            $this->clientPhoneNumberForm->delete();
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->reset('idToDelete');
        $this->modal('confirm-delete-phone-number')->close();
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return  $this->clientPhoneNumberForm->getFiltered($this->search);
    }
    public function openModal()
    {

        if ($this->clientPhoneNumberForm->id) {
            $this->clientPhoneNumberForm->setData($this->clientPhoneNumberForm->id);
        }
        $this->showModal = true;
    }
    public function hideModal()
    {
        $this->showModal = false;
        $this->clientPhoneNumberForm->reset(['id', 'phoneNumber', 'notes']);
        $this->clientPhoneNumberForm->resetValidation();
    }
    public function save(): void
    {
        $this->clientPhoneNumberForm->save();
        $this->hideModal();
        $message = $this->clientPhoneNumberForm->id ? CrudMessages::UPDATE_SUCCESS->value : CrudMessages::CREATE_SUCCESS->value;
        Flux::toast(variant: 'success', position: 'top-right', text: __($message));
    }
    public function edit($id)
    {
        $this->clientPhoneNumberForm->id = $id;
        $this->openModal();
    }
}
