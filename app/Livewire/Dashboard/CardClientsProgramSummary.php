<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use Livewire\Attributes\Computed;

class CardClientsProgramSummary extends Component
{
    protected ClientRepository $clientRepository;

    public function __construct()
    {
        $this->clientRepository = app(ClientRepository::class);
    }
    public function render()
    {
        return view('livewire.dashboard.card-clients-program-summary');
    }

    #[Computed]
    public function totalReCertificationsDue(): int
    {
        return $this->clientRepository->totalCertificationsDue();
    }
    #[Computed]
    public function totalReCertificationsOverdue(): int
    {
        return $this->clientRepository->totalCertificationsOverdue();
    }
}
