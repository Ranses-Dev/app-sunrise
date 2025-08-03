<?php

namespace App\Livewire\HowpaContract;

use App\Enums\CrudMessages;
use App\Enums\RecentLivingSituation;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HowpaContract as FormsHowpaContract;
use Flux\Flux;

#[Title('Create Howpa Contract')]
class Create extends Component
{
    public FormsHowpaContract $form;

    public ?string $ssnSearch = null;

    public function render()
    {
        return view('livewire.howpa-contract.create');
    }
    public function mount()
    {
        $this->form->getRecentLivingSituations();
    }

    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::CREATE_SUCCESS->value));
    }
    public function create()
    {
        $this->store();
        $this->redirect(route('howpa.contracts.index'), true);
    }
    public function createAndAddNew()
    {
        $this->store();
    }
    public function cancel()
    {
        $this->redirect(route('howpa.contracts.index'), true);
    }

    public function findClientBySsn()
    {
        $this->validate([
            'ssnSearch' => 'required|regex:/^\d{3}-\d{2}-\d{4}$/',
        ], [
            'ssnSearch.required' => 'SSN is required.',
            'ssnSearch.regex' => 'SSN must be in the format XXX-XX-XXXX.',
        ]);
        $this->form->findClientBySsn($this->ssnSearch);
    }
    public function updatedSsnSearch()
    {
        if (empty($this->ssnSearch)) {
            $this->form->reset(['client', 'clientId']);
        }
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
}
