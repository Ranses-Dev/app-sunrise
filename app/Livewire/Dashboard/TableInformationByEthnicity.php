<?php

namespace App\Livewire\Dashboard;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Repositories\EthnicityRepositoryInterface as EthnicityRepository;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TableInformationByEthnicity extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected EthnicityRepository $ethnicityRepository;
    public function boot()
    {
        $this->ethnicityRepository = app(EthnicityRepository::class);
    }

    public function render()
    {
        return view('livewire.dashboard.table-information-by-ethnicity');
    }

    #[Computed]
    public function ethnicities(): LengthAwarePaginator
    {
        return $this->ethnicityRepository->getEthnicitiesWithClientCount()->paginate(perPage: 5, pageName: 'information-ethnicity');
    }
}
