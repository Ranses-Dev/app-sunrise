<?php

namespace App\Livewire\Inspection;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Livewire\Forms\Inspection as InspectionForm;
use Illuminate\Support\Facades\Log;

#[Title('Edit Inspection')]
class Edit extends Component
{
    public InspectionForm $form;

    public function mount(int $id)
    {
        $this->form->id = $id;
        $this->form->setData();
    }
    public function render()
    {
        return view('livewire.inspection.edit');
    }
    public function save()
    {
        $this->form->save();
        $this->redirect(route('inspections.index'), true);
    }
    public function selectedInspectionAddress(int $id)
    {
        $this->form->addressId = $id;
        $this->form->getInspectionAddressById();
    }
    public function selectedLandlordAddress(int $id)
    {
        $this->form->landlordAddressId = $id;
        $this->form->getLandlordAddressById();
    }
    public function selectedTenantAddress(int $id)
    {
        $this->form->tenantAddressId = $id;
        $this->form->getTenantAddressById();
    }

    public function selectedLandlord(int $id)
    {
        Log::info('Selected Landlord ID: ' . $id);
        $this->form->landlordHowpaId = $id;
        $this->form->getLandlordById();
    }
    public function selectedTenant(int $id)
    {
        $this->form->tenantHowpaId = $id;
        $this->form->getTenantById();
    }
    public function updatedFormInspectionRequestedIncomplete()
    {
        if (!$this->form->inspectionRequestedIncomplete) {
            $this->form->reset('inspectionRequestedIncompleteNotes');
        }
    }
    public function updatedFormInspectionRequestedNotScheduled()
    {
        if (!$this->form->inspectionRequestedNotScheduled) {
            $this->form->reset('inspectionRequestedNotScheduledNotes');
        }
    }

    public function cancel()
    {
        $this->redirect(route('inspections.index'), true);
    }
}
