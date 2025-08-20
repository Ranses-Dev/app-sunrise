<?php

namespace App\Livewire\Components\Common;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Log as FacadesLog;
use Livewire\Attributes\Computed;

class ClientSearchSelect extends Component
{
    protected ClientRepositoryInterface $clientRepository;
    public bool $showModal = false;
    public string $searchClient = '';
    public function boot()
    {
        $this->clientRepository = app(ClientRepositoryInterface::class);
    }
    public function render()
    {
        return view('livewire.components.common.client-search-select');
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->clientRepository->getFiltered($this->searchClient)->paginate(pageName: 'clients-contracts', perPage: 10);
    }

    public function handleShowModal()
    {
        $this->showModal = true;
    }

    public function selectClient(int $clientId)
    {
        $this->dispatch('selectClient',  $clientId);
        $this->reset(['showModal', 'searchClient']);
    }
}
