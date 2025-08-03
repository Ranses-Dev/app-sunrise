<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Repositories\ClientRepositoryInterface;
use Livewire\Attributes\Computed;
#[Layout('layouts.app')]
class BadgeCertificationsDue extends Component
{
    protected ClientRepositoryInterface $clientRepository;


    public function render()
    {
        return view('livewire.components.badge-certifications-due');
    }
    public function mount(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    #[Computed]
    public function totalCertificationsDue(): int
    {
        return $this->clientRepository->totalCertificationsDue();
    }
}
