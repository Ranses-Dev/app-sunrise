<?php

namespace App\Livewire\Client\Relationships;

use App\Enums\CrudMessages;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\HouseholdMember as HouseholdMemberForm;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class HouseholdMembers extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public $showModal = false;
    public HouseholdMemberForm $form;
    public function mount(int $clientId)
    {
        $this->form->clientId = $clientId;
    }
    public function render()
    {
        return view('livewire.client.relationships.household-members');
    }

    public function delete($id)
    {
        $this->idToDelete = $id;
        $this->modal('confirm-delete-household-member')->show();
    }

    public function cancelDelete()
    {
        $this->reset('idToDelete');
        $this->modal('confirm-delete-household-member')->close();
    }

    public function confirmDelete()
    {
        if ($this->idToDelete) {
            $this->form->id = $this->idToDelete;
            $this->form->delete();
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->reset('idToDelete');
        $this->modal('confirm-delete-household-member')->close();
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return  $this->form->getFiltered($this->search);
    }
    public function openModal()
    {
        $this->form->getGenders();
        $this->form->getHouseholdRelationTypes();
        $this->form->getEthnicities();
        if ($this->form->id) {
            $this->form->setData($this->form->id);
        }
        $this->showModal = true;
    }
    public function hideModal()
    {
        $this->showModal = false;
        $this->form->reset(['id', 'firstName', 'lastName', 'dob', 'genderId', 'householdRelationTypeId', 'ethnicityId', 'editAddPayment', 'paymentAmount', 'frequencyPayment', 'paymentAmounts']);
        $this->form->resetValidation();
    }
    public function save(): void
    {
        $this->form->save();
        $this->hideModal();
        $message = $this->form->id ? CrudMessages::UPDATE_SUCCESS->value : CrudMessages::CREATE_SUCCESS->value;
        Flux::toast(variant: 'success', position: 'top-right', text: __($message));
    }
    public function edit($id)
    {
        $this->form->id = $id;
        $this->openModal();
    }
    public function addPayment()
    {
        $this->form->addPayment();
    }

    public function deletePayment(float $amount)
    {
        $this->form->deletePayment($amount);
    }
    public function updatedFormEditAddPayment()
    {
        if (!$this->form->editAddPayment) {

            $this->reset('form.paymentAmount', 'form.frequencyPayment', 'form.paymentAmounts');
            $this->resetValidation('form.paymentAmount');
            $this->resetValidation('form.frequencyPayment');
        }
    }
}
