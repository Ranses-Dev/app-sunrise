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
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Create Contract Meal')]
class Create extends Component
{
    use WithPagination, WithoutUrlPagination;
    public Collection $clients;
    public Client|null $client = null;
    public string $searchClient = '';
    public bool $showClientModal = false;
    public ContractMealForm $form;
    public function mount()
    {
        $this->form->loadProgramBranches();
        $this->form->loadDeliveryCosts();
        $this->form->loadFoodCosts();
        $this->form->loadProgramDeliveryCosts();
        $this->form->loadTerminationReasons();
        $this->form->loadClientServiceSpecialists();
    }
    public function render()
    {
        return view('livewire.contract-meal.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return $this->redirect(route('contract-meals.index'), navigate: true);
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return $this->redirect(route('contract-meals.index'), navigate: true);
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
