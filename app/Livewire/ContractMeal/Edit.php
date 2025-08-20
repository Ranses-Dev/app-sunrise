<?php

namespace App\Livewire\ContractMeal;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\ContractMeal as ContractMealForm;
use App\Models\Client;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Edit Contract Meal')]
class Edit extends Component
{
    use WithPagination, WithoutUrlPagination;
    public Collection $clients;
    public Client|null $client = null;
    public string $searchClient = '';
    public bool $showClientModal = false;
    public ContractMealForm $form;
    public function mount(int $id)
    {
        $this->form->loadProgramBranches();
        $this->form->loadDeliveryCosts();
        $this->form->loadFoodCosts();
        $this->form->loadProgramDeliveryCosts();
        $this->form->loadTerminationReasons();
        $this->form->setData($id);
        $this->client = $this->form->getClientById($this->form->clientId);
    }
    public function render()
    {
        return view('livewire.contract-meal.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return $this->redirect(route('contract-meals.index'), navigate: true);
    }
    public function cancel()
    {
        return $this->redirect(route('contract-meals.index'), navigate: true);
    }

    #[Computed]
    public function resultClients(): LengthAwarePaginator
    {
        return   $this->form->getClients($this->searchClient)->paginate(pageName: 'clients-contracts', perPage: 10);
    }
    #[On('selectClient')]
    public function selectClient(int $clientId)
    {
        $this->client = $this->form->getClientById($clientId);
        $this->form->clientId = $this->client?->id;
        $this->showClientModal = false;
    }
    public function updatedFormProgramBranchId()
    {
        $this->form->reset('clientServiceSpecialistId');
        $this->form->loadClientServiceSpecialists();
    }
    public function clearClient()
    {
        $this->reset('client');
    }
}
