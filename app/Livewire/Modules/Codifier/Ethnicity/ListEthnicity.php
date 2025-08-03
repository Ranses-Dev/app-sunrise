<?php

namespace App\Livewire\Modules\Codifier\Ethnicity;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use src\Modules\Codifier\Services\EthnicityService;

class ListEthnicity extends Component
{   use WithPagination;
    protected EthnicityService $service;
    public ?string $search = null;

    public function __construct()
    {
        $this->service = app(EthnicityService::class);
    }
    public function render()
    {
        return view('livewire.modules.codifier.ethnicity.list-ethnicity');
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->service->getAll($this->search)
            ->paginate(pageName: 'ethnicities-page');
    }
}
