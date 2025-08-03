<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use Livewire\Attributes\Computed;

class ClientsByProgram extends Component
{
    protected ClientRepository $clientRepository;

    public function mount(ClientRepository $clientRepository): void
    {
        $this->clientRepository = $clientRepository;
    }
    public function render()
    {
        return view('livewire.dashboard.clients-by-program');
    }

    #[Computed]
    public function clientsByProgram(): array
    {
        return $this->clientRepository->getClientsByHealthCareProvider();
    }
}
