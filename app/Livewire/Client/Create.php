<?php

namespace App\Livewire\Client;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use Flux\Flux;
use App\Livewire\Forms\Client as ClientForm;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

#[Title('Create Client')]
class Create extends Component
{
    use WithFileUploads;
    public ClientForm $form;
    public string $tabPicture = 'upload-picture';
    public function mount()
    {
        $this->form->getLegalStatuses();
        $this->form->getIdentificationTypes();
        $this->form->getCityDistricts();
        $this->form->getCountyDistricts();
        $this->form->getHealthcareProviders();
        $this->form->getHealthcareProviderPlans();
        $this->form->getGenders();
        $this->form->getEthnicities();
        $this->form->getHousingStatuses();
    }
    public function render()
    {
        return view('livewire.client.create');
    }

    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return $this->redirect(route('clients.index'), true);
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return $this->redirect(route('clients.index'), true);
    }
    public function updatedFormHealthcareProviderId()
    {
        $this->form->reset('healthcareProviderPlanId');
        $this->form->getHealthcareProviderPlans();
    }
    public function showCamera()
    {
        $this->dispatch('camera-show');
    }
    #[On('camera-capture:save')]
    public function getImageCamera(string $image)
    {
        $this->form->identificationPictureBase64 = $image;
    }
    public function updatedFormCountyDistrictId()
    {
        $this->form->reset('cityId');
        $this->form->getCities();
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
