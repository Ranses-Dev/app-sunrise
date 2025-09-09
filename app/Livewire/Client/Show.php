<?php

namespace App\Livewire\Client;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\Client as ClientForm;

#[Title('Client Details')]
class Show extends Component
{
    public ClientForm $form;
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
        return view('livewire.client.show');
    }
public function goBack()
    {

        $this->redirect(route('clients.index'), true);
    }
}
