<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use Livewire\Attributes\Computed;

#[Layout('layouts.app')]
class BadgeIdentificationsOverdue extends Component
{
    protected ClientRepository $clientRepository;

    public function __construct()
    {
        $this->clientRepository = app(ClientRepository::class);
    }
 
    public function render()
    {
        return view('livewire.components.badge-identifications-overdue');
    }

    #[Computed]
    public function identificationsOverdue(): int
    {
        return $this->clientRepository->totalIdentificationsOverdue();
    }
}
