<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Repositories\UserRepositoryInterface as UserRepository;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;

class CardClientsActiveByUser extends Component
{
    protected UserRepository $userRepository;
    public function mount(UserRepository $userRepository): void
    {
        $this->userRepository = $userRepository;
    }
    public function render()
    {
        return view('livewire.dashboard.card-clients-active-by-user');
    }

    #[Computed]
    public function clientsActiveByUser(): array
    {
        return $this->userRepository->getClientsActiveByUser();
    }
}
