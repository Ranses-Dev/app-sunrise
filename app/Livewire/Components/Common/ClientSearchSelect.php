<?php

namespace App\Livewire\Components\Common;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Repositories\ClientRepositoryInterface;
use Livewire\Attributes\Computed;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class ClientSearchSelect extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected ClientRepositoryInterface $clientRepository;
    public bool $showModal = false;
    public array $filters = [
        'search' => ''
    ];
    public string $label = '';

    public function mount(string $label = 'Search Client'): void
    {
        $this->label = $label;
    }
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
        return $this->clientRepository->getFiltered($this->filters)->paginate(pageName: 'clients-search-select', perPage: 10);
    }

    public function handleShowModal()
    {
        $this->showModal = true;
    }

    public function selectClient(int $clientId)
    {
        $this->dispatch('selectClient',  $clientId);
        $this->reset(['showModal', 'filters']);
    }
}
