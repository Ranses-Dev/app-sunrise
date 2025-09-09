<?php

namespace App\Livewire\ContractMeal;

use Livewire\Component;
use App\Livewire\Forms\ContractMeal as ContractMealForm;
use App\Models\Client;
use Livewire\Attributes\Title;

#[Title('Details Contract Meal')]
class Show extends Component
{
    public Client|null $client = null;
    public ContractMealForm $form;
    public function mount(int $id)
    {
        $this->form->loadProgramBranches();
        $this->form->loadDeliveryCosts();
        $this->form->loadFoodCosts();
        $this->form->loadProgramDeliveryCosts();
        $this->form->loadTerminationReasons();
        $this->form->loadClientServiceSpecialists();
        $this->form->setData($id);
        $this->client = $this->form->getClientById($this->form->clientId);
    }
    public function render()
    {
        return view('livewire.contract-meal.show');
    }
    public function goBack()
    {
        return $this->redirect(route('contract-meals.index'), navigate: true);
    }
}
