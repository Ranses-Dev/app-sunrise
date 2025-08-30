<?php

namespace App\Livewire\Components\Common;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ClientHowpaSelect extends Component
{
    protected  ClientRepositoryInterface $clientRepository;

    public bool $showModal = false;
    public string $search = '';
    public string $label = '';

    public function render()
    {
        return view('livewire.components.common.client-howpa-select');
    }

    public function mount( string $label = 'Search Client'): void
    {

        $this->label = $label;

    }
    public function boot()
    {
        $this->clientRepository = app(ClientRepositoryInterface::class);
    }

    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->clientRepository->getClientsHowpa( $this->search)->paginate(pageName: 'clients-howpa-select');
    }

    public function handleShowModal()
    {
        $this->showModal = true;
    }

    public function selectClient(int $clientId)
    {
        $this->dispatch('selected',  id: $clientId);
        $this->reset(['showModal', 'search']);
    }
}
