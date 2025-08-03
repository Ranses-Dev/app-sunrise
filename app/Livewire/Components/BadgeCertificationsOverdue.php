<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Repositories\ClientRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class BadgeCertificationsOverdue extends Component
{
    protected ClientRepositoryInterface $clientRepository;
    public function mount(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    public function render()
    {
        return view('livewire.components.badge-certifications-overdue');
    }
    #[Computed]
    public function totalCertificationsOverdue(): int
    {
        return $this->clientRepository->totalCertificationsOverdue();
    }
}
