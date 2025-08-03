<?php

namespace App\Livewire\Client;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Client as ClientForm;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

#[Title('Edit Client')]
class Edit extends Component
{
    use WithFileUploads;
    public ClientForm $form;
    public string $tabPicture = 'actual-picture';
    public string $tabRelationships = 'client-files';
    public function mount(int $id)
    {
        $this->form->getLegalStatuses();
        $this->form->getIdentificationTypes();
        $this->form->getCityDistricts();
        $this->form->getCountyDistricts();
        $this->form->getHealthcareProviders();
        $this->form->getHealthcareProviderPlans();
        $this->form->getGenders();
        $this->form->getEthnicities();
        $this->form->setData($id);
    }
    public function render()
    {
        return view('livewire.client.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return $this->redirect(route('clients.index'), navigate: true);
    }
    public function cancel()
    {
        return $this->redirect(route('clients.index'), navigate: true);
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
        $this->form->reset('identificationPicture');
        $this->form->identificationPictureBase64 = $image;
    }
    public function updatedFormCountyDistrictId()
    {
        $this->form->reset('cityId');
        $this->form->getCities();
    }
    public function updatedTabPicture()
    {
        $this->form->reset(['identificationPicture', 'identificationPictureBase64']);
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
