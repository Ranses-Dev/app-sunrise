<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use App\Repositories\HealthcareProviderRepositoryInterface as HealthcareProviderRepository;
use App\Repositories\EthnicityRepositoryInterface as EthnicityRepository;
use App\Repositories\ClientRepositoryInterface as ClientRepository;

#[Title('Dashboard')]
class Dashboard extends Component
{
    protected HealthcareProviderRepository $healthcareProviderRepository;
    protected EthnicityRepository $ethnicityRepository;
    protected ClientRepository $clientRepository;
    public function boot()
    {
        $this->healthcareProviderRepository = app(HealthcareProviderRepository::class);
        $this->ethnicityRepository = app(EthnicityRepository::class);
        $this->clientRepository = app(ClientRepository::class);
    }
    public function render()
    {
        return view('livewire.components.dashboard');
    }

    #[Computed]
    public function data(): array
    {
        return [
            'clientsByHealthcareProviders' => $this->healthcareProviderRepository->getClientsByHealthcareProvider(),
            'ethnicitiesWithClientCount' => $this->ethnicityRepository->getEthnicitiesWithClientCount(),
            'clientsAliveCount' => $this->clientRepository->getClientsAliveCount(),
            'clientsIdentificationsDueCount' => $this->clientRepository->getClientsIdentificationsDueCount(),
            'clientsIdentificationsOverdueCount' => $this->clientRepository->getClientsIdentificationsOverdueCount(),
            'clientsCertificationsDueCount' => $this->clientRepository->getClientsCertificationsDueCount(),
            'clientsCertificationsOverdueCount' => $this->clientRepository->getClientsCertificationsOverdueCount(),
        ];
    }

    public function goToTotalClients()
    {
        return $this->redirect(route('clients.index'), true);
    }
    public function goToIdentificationsDue()
    {
        return $this->redirect(route('clients-identifications-due.index'), true);
    }
    public function goToIdentificationsOverdue()
    {
        return $this->redirect(route('clients-identifications-overdue.index'), true);
    }

    public function goToCertificationsDue()
    {
        return $this->redirect(route('clients-certifications-due.index'), true);
    }
    public function goToCertificationsOverdue()
    {
        return $this->redirect(route('clients-certifications-overdue.index'), true);
    }
}
