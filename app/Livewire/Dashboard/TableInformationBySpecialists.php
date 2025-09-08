<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Repositories\UserRepositoryInterface as UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class TableInformationBySpecialists extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected UserRepository $userRepository;

    public function boot()
    {
        $this->userRepository = app(UserRepository::class);
    }
    public function render()
    {
        return view('livewire.dashboard.table-information-by-specialists');
    }
    #[Computed]
    public function specialists(): LengthAwarePaginator
    {
        return $this->userRepository->getInformationBySpecialists()->paginate(perPage: 10, pageName: 'information-by-specialists');
    }
}
