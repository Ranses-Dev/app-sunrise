<?php

namespace App\Livewire\Modules\Codifier\Ethnicity;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use src\Modules\Codifier\Services\EthnicityService;

class Index extends Component
{
    public EthnicityService $service;
    public ?string $search = null;
    public function render()
    {
        return view('livewire.modules.codifier.ethnicity.index');
    }

    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->service->getAll($this->search)
            ->paginate(pageName: 'ethnicities-page');
    }
}
