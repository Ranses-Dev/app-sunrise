<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use Livewire\Attributes\Computed;

class CardClientsByProgram extends Component
{
    protected ClientRepository $clientRepository;
    public function __construct()
    {
        $this->clientRepository = app(ClientRepository::class);
    }
    public function render()
    {
        return view('livewire.dashboard.card-clients-by-program');
    }
    #[Computed]
    public function clientsByProgram(): array
    {
        return $this->clientRepository->getClientsByPrograms();
    }
}
