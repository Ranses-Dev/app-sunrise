<?php

namespace App\Livewire\HowpaContract;

use App\Enums\CrudMessages;
use App\Enums\RecentLivingSituation;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HowpaContract as FormsHowpaContract;
use Flux\Flux;

#[Title('Edit Howpa Contract')]
class Edit extends Component
{
    public FormsHowpaContract $form;

    public function mount(int|string $id)
    {
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.howpa-contract.edit');
    }

    public function save()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        $this->redirect(route('howpa.contracts.index'), true);
    }

    public function cancel()
    {
        $this->redirect(route('howpa.contracts.index'), true);
    }
    public function updatedFormRecentLivingSituation()
    {
        if ($this->form->recentLivingSituation != RecentLivingSituation::OTHER->name) {
            $this->form->reset(['recentLivingSituationNotes']);
        }
    }
    public function addEmergencyContactOne()
    {
        $this->form->getEmergencyContactOne();
    }
    public function addEmergencyContactTwo()
    {
        $this->form->getEmergencyContactTwo();
    }
    public function removeEmergencyContactOne()
    {
        $this->form->reset(['emergencyContactOne']);
        $this->form->getEmergencyContacts();
    }
    public function removeEmergencyContactTwo()
    {
        $this->form->reset(['emergencyContactTwo']);
        $this->form->getEmergencyContacts();
    }

    public function updatedFormHasCheckingAccount()
    {
        if (!$this->form->hasCheckingAccount) {
            $this->form->reset(['checkingAvgBalanceSixMonths']);
        }
    }
    public function updatedFormHasSavings()
    {
        if (!$this->form->hasSavings) {
            $this->form->reset(['savingsBalance']);
        }
    }

    #[On('selectClient')]
    public function selectClient(int $clientId)
    {
        $this->form->getClientById($clientId);
        $this->form->clientId = $this->form->client?->id;
        $this->form->getCities();
        $this->form->getClientPhoneNumbers();
        $this->form->getEmergencyContacts();
        $this->form->getProgramBranches();
        $this->form->getClientServiceSpecialists();
    }

    public function clearClient()
    {
        $this->form->reset(['client', 'clientId']);
    }

    public function updatedFormProgramBranchId()
    {
        $this->form->reset(['clientServiceSpecialistId']);
        $this->form->getClientServiceSpecialists();
    }
}
